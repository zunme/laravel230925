<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Carbon\Carbon;
use Auth;

use App\Models\Holidays;
use App\Classes\Sondata;
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
}