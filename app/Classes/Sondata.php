<?php

namespace App\Classes;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Sleep;
use Illuminate\Support\Facades\Cache;

use App\Models\Lunar as LunarModel;

class Sondata
{
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
}