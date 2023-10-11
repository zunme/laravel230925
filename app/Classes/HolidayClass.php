<?php

namespace App\Classes;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Models\Holidays;

class HolidayClass
{
	public $sunday = Carbon::SUNDAY;
	public $saturday = Carbon::SATURDAY;
	protected $last_update;
	
	public function makeDefault(){
		$thisyear = Carbon::today()->format('Y');
		$this->getHoliday($thisyear);
		$beforeyear = Carbon::today()->subYears()->format('Y');
		if( Holidays::where('locdate','>', $beforeyear.'0000')->where('locdate','<', $beforeyear.'1300')->count() < 1 ) $this->getHoliday($beforeyear);
		$nextyear = Carbon::today()->addYears()->format('Y');
		$this->getHoliday($nextyear);
		
		Holidays::where('last_update', '<' ,$this->last_update->subMinutes())->where('locdate','>', $thisyear.'0000') ->delete();
		\Cache::store('file')->flush();
	}
	public function getHoliday($year, $month=null){
		if( !$this->last_update ) 		$this->last_update = Carbon::now()->setTimezone('Asia/Seoul');
		$params = [
			'solYear'=>$year,
			'numOfRows'=>'9999',
			'_type'=>'json'
		];
		if( $month ){
			$params['solMonth'] = $month;
		}
		
		$url ="//https://apis.data.go.kr/B090041/openapi/service/SpcdeInfoService/getRestDeInfo?solYear=".$params['solYear'].
			(isset($params['solMonth']) ? '&solMonth='.$params['solMonth'] : '')
			."&_type=json&numOfRows=9999&ServiceKey=ljZbBpfZRi93JyseB0PtrB0fO%2FVOnreKvQNsyU0Lljf%2BM7SmouNix5P0Q9tSoTeVguxPX2e5Dr65%2ByYMzdJo5Q%3D%3D";
		
		$response = Http::get($url);
		echo $url.PHP_EOL;
		if( $response->body() ){
			$ret =  json_decode( $response->body(), true);
			if( $ret['response']['header']['resultCode']=='00'){
				$items = $ret['response']['body']['items']['item'];

				//Holidays::insertOrIgnore( $items );
				//Holidays::updateOrInsert( $items );
				foreach ( $items as $item ){
					$item['last_update'] =$this->last_update;
					if(Holidays::where('locdate', $item['locdate'])->count() < 1 ) Holidays::create($item);
					else {
						$key = $item['locdate']; 
						unset($item['locdate']);
						Holidays::where('locdate', $key )->update( $item );
					}
				}
			}
		}else dump( $response );

	}
	
	public function getWorkDay( Carbon|string $date, $day=1){
		//\Cache::store('file')->flush();
		if( $day > 380 ) throw new Exception ('최대 380일까지만 지원합니다');
		$date = ( gettype($date)=='string' ? Carbon::parse($date, 'Asia/Seoul') : (clone $date) );
		
		$diff = abs($day);
		$sign = $day > 0 ? 1 : -1;
		
		$key = 'holi_'.$date->format('Ymd').'_'. ( $sign > 0 ? 'P':'M') .$diff;
	
		$ret = \Cache::store('file')->remember( $key , 86400*5 , function () use($date,$day, $diff, $sign ) {
			$limit = $day*3;
			$limit = $limit < 20 ? 20 : $limit;
			
			$holidayqry = Holidays::select('*')->where('isHoliday','Y');
			
			if( $sign > 0 ) {
				$holidayqry->where('locdate', '>', $date->format('Ymd'))->orderBy('locdate', 'asc')->limit($limit);
			}else{
				$holidayqry->where('locdate', '<', $date->format('Ymd'))->orderBy('locdate', 'desc')->limit($limit);
			}
			$holidayobj = $holidayqry->get();
			$checkHoliday = array();
			foreach( $holidayobj as $row ){
				$checkHoliday[$row->locdate] = true;
			}
			$diffcheck = 0;
			$i = 0;
			$holidaArr = [];
			// \Log::debug("holiday start ".(clone $date)->addDays( $sign )->toDateString() );
			while(true){
				$checkdate = $date->addDays( $sign );
				if(isset($checkHoliday[$checkdate->format('Ymd')])) {
					// \Log::info("holi day : ". (clone $checkdate)->format('Y-m-d') );
					$holidaArr[] = ['isHoliday'=>'Y','seq'=>1,'dayOfWeek'=>$checkdate->dayOfWeek, 'date'=>(clone $checkdate)->format('Y-m-d')];
					continue;
				}
				else if( $checkdate->dayOfWeek == $this->sunday || $checkdate->dayOfWeek == $this->saturday ) {
					// \Log::info("holi N day : ". (clone $checkdate)->format('Y-m-d') );
					$holidaArr[] = ['isHoliday'=>'N','seq'=>2,'dayOfWeek'=>$checkdate->dayOfWeek == $this->sunday ? 'sun':'sat', 'date'=>(clone $checkdate)->format('Y-m-d')];
					continue;
				}
				++$diffcheck;
				if( $diff == $diffcheck ) break;
				if( $i > 480 ) throw new Exception ('최대 지원일 수 를 넘겼습니다');
				$i++;
			}
			// \Log::debug("holiday d", ["holi"=>$holidaArr]);
			return ['workdate'=>$checkdate, 'holidays'=>$holidaArr];
			return ['workdate'=>$checkdate->toDateString(), 'holidays'=>$holidaArr, 'cached'=>Carbon::now()->setTimezone('Asia/Seoul')->toString()];
		});
		return $ret;
	}
	//날짜로 워크데이, 같은 워크데이에 속하는 날짜들 뽑기
	public function makeCalcDates( $date=null, $days = 1){
		// \Cache::store('file')->flush();
		$date =  $date ? Carbon::parse( $date, 'Asia/Seoul') : Carbon::today()->setTimezone('Asia/Seoul');
		$startDate = (clone $date);
		$initCalcDate = null;
		$calcdates =[];
		$temp = array();
		/*
		for( $i = 0; $i <=30 ; $i++){
			$clone = (clone $startDate);
			$res = $this->getWorkDay($clone->toDateString() , $days);
			if( !$initCalcDate  )$initCalcDate  = $res['workdate'];
			if ( $initCalcDate->toDateString() ==  $res['workdate']->toDateString() ) $calcdates[] = $clone;
			else break;
			$startDate->addDays(1);
		}
		
		$startDate = (clone $date);
		for( $i = 0; $i <= 30 ; $i++){
			$startDate->addDays(-1);
			$clone = (clone $startDate);
			$res = $this->getWorkDay($clone->toDateString() , $days);
			if ( $initCalcDate->toDateString() ==  $res['workdate']->toDateString() ) $calcdates[] = $clone;
			else break;
		}
		*/
		$clone = (clone $startDate);
		
		$res = $this->getWorkDay($clone->toDateString() , $days);
		if( !$initCalcDate  )$initCalcDate  = $res['workdate'];
		
		//$temp = 
		$lastday = null;
		if( $initCalcDate->format('t') == $initCalcDate->format('d')) $lastday = true;
		
		$dates = array();
		foreach( $calcdates as $val ){
			$dates[] = $val->toDateString();
		}
		asort($dates);
		$other_days = $this->getOtehrDays($initCalcDate , $days);
		
		$ret = ['init_date'=>$date->toDateString(), 'work_date'=> $initCalcDate->toDateString(), 'dates'=> $dates,'workday_is_lastday'=>$lastday , "holidays" => $res['holidays'], 'work_dates'=>$other_days];
		return $ret;
	}
	
	public function getOtehrDays(Carbon $init_work_date, $day=1){
		
		$diff = abs($day);
		$sign = $day > 0 ? 1 : -1;
		
		$newdate = (clone $init_work_date);
		$initdate = (clone $init_work_date)->toDateString();
		
		$key = 'work_'.$newdate->format('Ymd').'_'. ( $sign > 0 ? 'P':'M');
		
		$ret = \Cache::store('file')->remember( $key , 86400*5 , function () use($newdate, $initdate, $sign,$diff) {
			$init_lastdate = (clone $newdate)->endOfMonth()->toDateString();
			$others =[];
			$lastday = false;
			$lastdate = '';
			$days=[];
			$reservations=[];
			$holidays =[];
			if( $newdate->format('t') == $newdate->format('d')) {
				$lastday = true;
				$lastdate = $newdate->format('t');
			}
			$init_temp = (clone $newdate);
			$days[] = $init_temp->format('d');
			$others[] = $init_temp->toDateString();
			$reservations[$init_temp->format('d')] = $init_temp->toDateString();

			$day_num=[];
			if( $sign == 1){ 
				$holidayqry = Holidays::select('*')->where('isHoliday','Y');

				if( $sign > 0 ) {
					$holidayqry->where('locdate', '>', $newdate->format('Ymd'))->orderBy('locdate', 'asc')->limit(20);
				}else{
					$holidayqry->where('locdate', '<', $newdate->format('Ymd'))->orderBy('locdate', 'desc')->limit(20);
				}

				$holidayobj = $holidayqry->get();
				$checkHoliday = array();
				foreach( $holidayobj as $row ){
					$checkHoliday[$row->locdate] = true;
				}

				for( $i = 0; $i < 10; $i++){
					$checkdate2 = $newdate->addDays( $sign );
					$temp = (clone $checkdate2);
					if( isset($checkHoliday[$checkdate2->format('Ymd')]) ) {
						$holidays[] = ['isHoliday'=>'Y','seq'=>1,'dayOfWeek'=>$temp->dayOfWeek, 'date'=>$temp->format('Y-m-d')];
					}
					else if( $checkdate2->dayOfWeek == $this->sunday || $checkdate2->dayOfWeek == $this->saturday ) {
						$holidays[] =['isHoliday'=>'N','seq'=>2,'dayOfWeek'=>$temp->dayOfWeek == $this->sunday ? 'sun':'sat', 'date'=>$temp->format('Y-m-d')];
					}
					else break;

					$others[] = $temp->toDateString();
					if( $temp->format('t') == $temp->format('d')){
						$lastday = true;
						$lastdate = $temp->format('t');
					}
					$days[] = $temp->format('d');
					/*
					$init_day_info = [
						'day'=> $init_work_date->format('d'),
						'day_num'=>(int)$init_work_date->format('d'),
						'last_day'=>$init_work_date->format('t'),
						'date'=>(clone $init_work_date)
					],
					*/
					$reservations[$temp->format('d')] = $temp->toDateString();
				}

				if( $lastday ) {
					$days[] ="-1";
					$reservations['-1'] = $init_lastdate;
					for( $i= (int)$lastdate; $i <= 31 ; $i++ ){
						$days[] = sprintf("%2d", $i);
						$reservations[sprintf("%2d", $i)] = $init_lastdate;
					}
				}
				$days = array_unique($days);
				asort( $days );
				$day_num = [];
			}
			
			foreach( $days as $row){
				$day_num[] = (int)$row;
			}
			// \Log::info("not cached");
			return ['initdate'=>$initdate,"lastday"=> $lastday, "days"=>$others,'day_digit'=>$days,'day_num'=>$day_num,'holidays'=>$holidays,'reservations'=>$reservations];
		});
		return $ret;
	}
}