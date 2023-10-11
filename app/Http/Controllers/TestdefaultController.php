<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

// tmappoi
use App\Classes\Tmap;

class TestdefaultController extends Controller
{	
	public function tmappoi(Request $request){
		/*검색*/
		$tmap = new Tmap();
		try{
			return $this->success( $tmap->poi($request->search) );
		}catch(\Exception $e){
			return $this->error( $e->getMessage());
		}
	}
	public function tmapRoute(){
		$tmap = new Tmap();
		$start=['pkey'=>"35305800","name"=>"해인사","frontLon"=>"128.09097045","frontLat"=>"35.79131687"];
		$end=['pkey'=>"1094633601","name"=>"해인사시외버스터미널 주차장","frontLon"=>"128.08916504","frontLat"=>"35.79215007"];
		$routes=[
			['pkey'=>"1009502201","name"=>"박통사","frontLon"=>"128.40154799","frontLat"=>"36.01435278"],
			['pkey'=>"1086730701","name"=>"해인사북카페","frontLon"=>"128.09613643","frontLat"=>"35.79989932"]
		];
		$res = $tmap->routeOptimization( $start, $end, $routes, null);
		return $this->success( $res);
	}
	public function tmapDistance(){
		/* 거리 */
		$tmap = new Tmap();
		$data = [
			["pkey"=>"35305801"],
			["pkey"=>"37317901"],
		];
		dd($tmap->poiDistance($data, 'api'));
	}
}