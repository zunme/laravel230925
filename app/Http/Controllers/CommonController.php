<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Carbon\Carbon;

use App\Models\Holidays;

class CommonController extends Controller
{
	public function holidays(){
		$year = Carbon::now()->subYear()->format('Y');
		
		$holiday = \Cache::store('file')->remember( "holi_y_".$year , 86400*1 , function () use($year) {
			return Holidays::where('locdate', '>', $year.'0000' )->where('isHoliday','Y')->get();
		});
		return $this->success($holiday);
	}
}