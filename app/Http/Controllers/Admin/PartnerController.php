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
        if( !config('site.use_sigungu',false) ){
            $data = Partner::
                with([
                    'availarea'=>function($q){
                        return $q->where(['is_use'=>'Y'])->whereNull('avail_sigunguCode');
                    }
                ])
                ->select('partners.*');
        }else{
            $data = Partner::
            with([
                'availarea'=>function($q){
                    return $q->select('avail_siCode','partner_id',DB::raw("count(1) as cnt") )
                        ->where(['is_use'=>'Y'])
                        ->whereNotNull('avail_sigunguCode')
                        ->groupBy('partner_id','avail_siCode');
                }
            ])
            ->select('partners.*');
        }
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
    public function store(Request $request){
        $formValidate = $request->validate([
            'name'=>'bail|required|string',
            'userid'=>'bail|required|string',
            'tel'=>'bail|required|string',
            'password'=>'bail|required|string',
        ],[
            "name.*"=>"아이디를 입력해주세요",
            "userid.*"=>"이름을 입력해주세요",
            "tel.*"=>"전화번호를 입력해주세요",
            "password.*"=>"비밀번호를 입력해주세요",
        ],[]
        );
        try {
            $formValidate['tel'] = preg_replace('/[^0-9]*/s', '', $formValidate['tel']);
            $partner = Partner::create( $formValidate );
        } catch(Exception $e ){
            return $this->error( $e->getMessage());
        }
        return $this->success($partner);
    }
    public function show($partner_id){
        $data = Partner::find( $partner_id );
        return $this->success($data);
    }
    public function edit($partner_id){
    }
    public function update(Request $request, $partner_id)
    {
        $formValidate = $request->validate([
            'name'=>'bail|required|string',
			'tel'=>'bail|required|string',
        ],[
            "move_type.*"=>"이름을 입력해주세요",
			"tel.*"=>"전화번호를 입력해주세요",
        ],[]
        );
        try {
            $partner = Partner::findOrFail($partner_id);
            $formValidate['tel'] = preg_replace('/[^0-9]*/s', '', $formValidate['tel']);
            $partner->update( $formValidate );
        } catch (ModelNotFoundException $exception) {
            return $this->error('파트너 정보를 찾을 수 없습니다.',404);
        } catch(Exception $e ){
            return $this->error( $e->getMessage());
        }
        return $this->success();
    }
    public function updatePassword(Request $request, $partner_id)
    {
        $formValidate = $request->validate([
            'password'=>'bail|required|string',
        ],[
            "password.*"=>"변경할 비밀번호를 입력해주세요",
        ],[]
        );
        try {
            $partner = Partner::findOrFail($partner_id);
            $partner->password = \Hash::make($request->password);
            $partner->save();
        } catch (ModelNotFoundException $exception) {
            return $this->error('파트너 정보를 찾을 수 없습니다.',404);
        } catch(Exception $e ){
            return $this->error( $e->getMessage());
        }
        return $this->success();
    }
    public function destroy($partner_id)
    {
    }
}