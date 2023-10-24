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
}