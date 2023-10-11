<?php

namespace App\Classes;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Enums\Srid;

use App\Models\TmapPoi;
use App\Models\TmapPoiCache;

class Tmap
{
	public $appkey;
	public $savepoi = true;
	public $use_cache = true;
	public $cach_duration = 30;//days
	public $item_count = 20; //검색갯수 max 200
	public $old_date;
	
	public function __construct(){
        $this->appkey = config('site.tmap_key',env('TMAP_KEY'));
		$this->old_date = carbon::now()->subDay($this->cach_duration)->startOfDay();
		//$this->old_date = carbon::now()->addDay(1);
    }
	public function getKey(){
		return $this->appkey;
	}
	public function setKey(String $key){
		$this->appkey = $key;
	}
	
	public function poi(String|Null $search){
		if( !$search) throw new Exception('검색어를 입력해주세요');
		
		if( $this->use_cache){
			$cache = TmapPoiCache::where('search', $search)->first();
			if( $cache && $cache->updated_at >= $this->old_date ) {
				return $cache->result;
			}
		}
		
		$param = [
			'version'=>'1',
			'searchKeyword'=>$search,
			'earchType'=>'all',
			'page'=>1,
			'count'=>$this->item_count,
			'resCoordType'=>'WGS84GEO',
			'multiPoint'=>'N',
			'searchtypCd'=>'A',
			'reqCoordType'=>'WGS84GEO',
			'poiGroupYn'=>'N',
		];
		$url = "https://apis.openapi.sk.com/tmap/pois";
		$response = $this->defaultHttp()->get($url,$param);
		if( $response->successful() ) {
			$json =$response->json();
			if( $this->savepoi){
				foreach( $json['searchPoiInfo']['pois']['poi'] as $row){
					try{
						TmapPoi::findOrFail( $row['pkey']);
					}catch(ModelNotFoundException $e){						
						$row['poiobj'] = $row;
						//$row['crdnt'] = DB::raw("point(".$row['frontLon'].",".$row['frontLat'].")");
						//$row['crdnt'] = [$row['frontLon'], $row['frontLat']];
						$row['crdnt'] =  new Point($row['frontLat'],$row['frontLon'], Srid::WGS84->value);
						$row['sido_code'] = substr($row['legalDongCode'],0,2);
						
						TmapPoi::create( $row );
					}catch(Exception $e){
						throw new Exception($e->getMessage() );
					}
				}
				//if( count($ins) ) TmapPoi::insertOrIgnore( $ins );
			}
			try{
				if($this->use_cache) {
					if( $cache ){
						$cache->result = $json;
						$cache->save();
					}
					else TmapPoiCache::create(['search'=>$search, 'result'=>$json]);
				}
			}catch(Exception $e){
				throw new Exception($e->getMessage() );
			}
			return $json;
		}else {
			throw new Exception('API ERROR OCCURED');
		}
	}
	
	public function poiDistance( Array $routes, $type=null ){
		if( count($routes)<2 ) throw new Exception("출발지와 목적지가 있어야 합니다.");
		$start=null;
		$getRes =[];
		foreach( $routes as $route){
			$routeRow = TmapPoi::find($route['pkey']);
			if( !$start) {
				$start = $routeRow;
				continue;
			}
			$end = $routeRow;
			if( $type =="api") $getRes[] = $this->apiDistance( $start, $end);
			else $getRes[] = $this->sqlDistance( $start, $end);
			$start = $end;
		}
		$sum = 0;
		foreach( $getRes as $row){
			$sum += $row;
		}
		return ['total'=>$sum,'distnaces'=>$getRes];
	}
	
	public function routeOptimization ($start, $end,  Array $routes, Carbon | NULL $starttime ){
		/*$route
			무료건수가 적어서 패스..
			["pkey","name","frontLon","frontLat"]
		*/
	}
	
	public function apiDistance( TmapPoi $start , TmapPoi $end ){
		$params = [
			'startX'=>$start->frontLon,
			'startY'=>$start->frontLat,
			'endX'=>$end->frontLon,
			'endY'=>$end->frontLat,
		];
		$response = $this->defaultHttp()->get('https://apis.openapi.sk.com/tmap/routes/distance',$params);
		if( $response->successful() ) {
			$json = $response->json();
			return $json['distanceInfo']['distance'];
		}else throw new Exception('API ERROR OCCURED');
	}
	public function sqlDistance( TmapPoi $start , TmapPoi $end ){
		$sql = "SELECT ST_DISTANCE( (SELECT crdnt from tmap_pois WHERE pkey={$start->pkey}), (SELECT crdnt from tmap_pois WHERE pkey={$end->pkey}) ) AS dist";
		$res = \DB::select($sql);
		return (int)$res[0]->dist;
	}
	public function clearCache(String|Null $search=null){
		if( !$search ) {
			\DB::statement('truncate tmap_poi_caches');
		}
		else {
			TmapPoiCache::whereLike('search',"{$search}%")->delete();
		}
	}
	public function clearOldCache(){
		TmapPoiCache::where( 'updated_at','<',$this->old_date)->delete();
	}
	
	public function paramsToQuery(Array $params){
		return  http_build_query($params);
	}
	public function defaultHttp(){
		return Http::withHeaders([
			'appKey' => $this->getKey(),
			'Accept'=> 'application/json',
		]);
	}

}