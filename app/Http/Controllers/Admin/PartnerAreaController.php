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
use App\Models\DongCode;

class PartnerAreaController extends Controller
{
    public function index(Request $request, $partner_id){
        $data = PartnerArea::
            select(
                DB::raw(" ifnull(avail_sigunguCode , avail_siCode) as avail_siCode ")
                )
            ->where(['partner_id'=> $partner_id, 'is_use'=>'Y'])
            ->pluck('avail_siCode');
        return $this->success($data);
    }
    public function create(){

    }
    public function store(){
        
    }
    public function updateAreas(Request $request, $partner_id){

        if( !config('site.use_sigungu',false) ){
            $avail = $request->areas;
            if( !$avail) $avail = [];
            $unuse = PartnerArea::where('partner_id', $partner_id)
                ->whereNotIn('avail_siCode',$avail)
                ->update(['is_use'=>'N']);
            foreach( $avail as $code){
                $row = PartnerArea::where(['partner_id'=> $partner_id,'avail_siCode'=>$code])->first();
                if( $row ) {
                    if($row->is_use !='Y') {
                        $row->update(['is_use'=>'Y']);
                    }
                }else {
                    PartnerArea::create( ['partner_id'=> $partner_id,'avail_siCode'=>$code] );
                }
            }
        }else{
            $avail = $request->gungu;
            if( !$avail) $avail = [];
            $unuse = PartnerArea::where('partner_id', $partner_id)
                ->whereNotIn('avail_sigunguCode',$avail)
                ->update(['is_use'=>'N']);
            foreach( $avail as $code){
                $row = PartnerArea::where(['partner_id'=> $partner_id,'avail_sigunguCode'=>$code])->first();
                if( $row ) {
                    if($row->is_use !='Y') {
                        $row->update(['is_use'=>'Y']);
                    }
                }else {
                    $sido_cd = $this->getSidoCodeWithGungu($code);
                    PartnerArea::create( ['partner_id'=> $partner_id,'avail_siCode'=>$sido_cd,'avail_sigunguCode'=>$code] );
                }
            }
        }
        return $this->success();
    }

    public function show($partner_id){
        return $this->success(['id'=>$partner_id]);
    }
    public function edit($partner_id){
    }
    public function update(Request $request, $partner_id, $area_id)
    {
    }
    public function destroy($partner_id, $area_id)
    {
    }
}