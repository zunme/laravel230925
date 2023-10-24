<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Events\PresenceEvent;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use DataTables;
use DB;

use App\Models\Partner;
use App\Models\PartnerArea;

class PartnerController extends Controller
{
    public function index(Request $request){
        $data = Partner::select('partners.*');
        if( $request->sidoCode ){
            $sido = PartnerArea::select('partner_id')->where('avail_siCode',$request->sidoCode)->pluck('partner_id');
            $data->whereIn('id', $sido);
        }
        if( $request->searchstr && $request->searchtype){
            $data->where($request->searchtype , 'like',"%{$request->searchstr}%");
        }

        return DataTables::eloquent($data)
		->toJson();
    }
    public function create(){

    }
    public function store(){
        
    }
    public function show($partner_id){
        return $this->success(['id'=>$partner_id]);
    }
    public function edit($partner_id){
    }
    public function update(Request $request, $partner_id)
    {
    }
    public function destroy($partner_id)
    {
    }
}