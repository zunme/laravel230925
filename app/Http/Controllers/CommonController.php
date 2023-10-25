<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Carbon\Carbon;
use Auth;

use App\Models\Holidays;
use App\Classes\Sondata;

use App\Models\DongCode;

class CommonController extends Controller
{
	public function holidays(){
		$year = Carbon::now()->subYear()->format('Y');
		
		$holiday = \Cache::store('file')->remember( "holi_y_".$year , 86400*1 , function () use($year) {
			return Holidays::where('locdate', '>', $year.'0000' )->where('isHoliday','Y')->get();
		});
		return $this->success($holiday);
	}
	public function sondays(){
		$obj = new Sondata();
		$data = $obj->getSonDays();
		return response()->json($data);
	}
	public function checkAuthUser(Request $request){
		$user = Auth::guard('web')->user();
		if( $user ) return $this->success(['logined'=>true]);
		else return $this->error('',421,['logined'=>false]);
	}
	public function sigungu(){
		\Cache::store('file')->forget('sigungu_list');
        $sigungu = \Cache::store('file')->remember('sigungu_list',86400* 100, function(){
            $arr = [];
            foreach( config('customsido.simple') as $key=>$name){
                $arr[$key] = [
                    'sido_code'=>$key,
                    'short_name'=>$name,
                    'id'=>null,
                    'full_name'=>null,
                    'gungu'=>[]
                ];
            }
    
            $sido = DongCode::
            select( 'id','lawd_cd','sido_cd','sigungu_cd','sido','sgg' )
            ->where(['depth'=>'1', 'del_dt'=>''])->get();
            foreach( $sido as $row){
                $arr[ $row['sido_cd']]['id'] = $row->id;
                $arr[ $row['sido_cd']]['full_name'] = $row->sido;
            }
            $gungu = DongCode::
                select( 'id','lawd_cd','sido_cd','sigungu_cd','sido','sgg' )
                ->where(['depth'=>'2', 'del_dt'=>''])->orderBy('lawd_cd')->get()->toArray();
    
            foreach ( $gungu as $row){
                $arr[ $row['sido_cd']]['gungu'][] = $row;
            }
            $ret = [];
            foreach( $arr as $id=>$row){
                $ret[] = $row;
            }
            return $ret;
        });

        return $this->success($sigungu);
    }
}