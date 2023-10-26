<?php

namespace App\Classes;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Sleep;
use Illuminate\Support\Facades\Cache;

use App\Models\Lunar as LunarModel;

class LunarClass
{
	public function createSonData(){
		$last = LunarModel::orderBy('id','desc')->first();
		if( $last ){
			$date = $last->date->addDays();
		}else {
			$date = Carbon::now()->setTimezone('Asia/Seoul')->firstOfMonth();	
		}
		$lastday = (int)(clone $date)->endOfMonth()->format('d');
		for( $j =0 ; $j < 5; $j ++){
			for( $i=0; $i < $lastday; $i ++ ){
				dump($date->toDateString() );
				$this->getLunar($date);
				$date->addDays();
				Sleep::for(500)->milliseconds();
			}
			Sleep::for(10)->seconds();
		}
		$this->clearCache();
		$this->getSonDays();
		echo "done";
		return true;
	}
	public function getSonDays(){
		return Cache::store('file')->remember('sonDays', 86400*100, function () {
			return LunarModel::select('date')->whereIn('lunDay',['9','10','19','20','29','30'])
				->where('id','>=', Carbon::now()->setTimezone('Asia/Seoul')->subMonthNoOverflow()->startOfMonth()->format('Ymd'))
				->get();
		});
	}
	public function clearCache(){
		Cache::store('file')->forget('sonDays');
	}
	public function getLunar($date){
		$endpoint = 'https://apis.data.go.kr/B090041/openapi/service/LrsrCldInfoService/getLunCalInfo';
		$encKey="ljZbBpfZRi93JyseB0PtrB0fO%2FVOnreKvQNsyU0Lljf%2BM7SmouNix5P0Q9tSoTeVguxPX2e5Dr65%2ByYMzdJo5Q%3D%3D";
		$deckey="ljZbBpfZRi93JyseB0PtrB0fO/VOnreKvQNsyU0Lljf+M7SmouNix5P0Q9tSoTeVguxPX2e5Dr65+yYMzdJo5Q==";
		
		$params = [
			'serviceKey'=>$deckey,
			'solYear'=>$date->format('Y'),
			'solMonth'=>$date->format('m'),
			'solDay'=>$date->format('d'),
			'_type'=>'json'
		];
		$response = Http::retry(2, 1000)->get($endpoint,$params);
		if( $response->successful() ){
			$res = $response->json();
			$item = $res['response']['body']['items']['item'];
			$item['id']= $date->format('Ymd');
			$item['date'] = $date->toDateString();
			try{
				LunarModel::create($item);
			}catch(\Exception $e){
				dump( $res );
				dump( $item );
				throw new \Exception ($e->getMessage());
			}
		}else {
			echo ( $response->body() );
			dd( $response);
		}
	}
}