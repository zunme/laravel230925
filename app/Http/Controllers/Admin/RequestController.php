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

use App\Models\User;
use App\Models\MoveRequest;

class RequestController extends Controller
{
    public function list(Request $request ){
        $data = MoveRequest::with(['user','review'=>function($q){return $q->select('id','move_request_id');}])
            ->select( 'move_requests.*')
            ->leftJoin('users','move_requests.user_id','=','users.id')
            ;
        if( $request->searchstr && $request->searchtype){
            $data->where($request->searchtype , 'like',"%{$request->searchstr}%");
        }
        if( $request->move_date ){
            $data->whereDate('move_requests.move_date',$request->move_date);
        }
        if( $request->created_at ){
            $data->whereDate('move_requests.created_at',$request->created_at);
        }
        if( $request->req_status ){
            $data->where('move_requests.req_status',$request->req_status);
        }
        
		return DataTables::eloquent($data)
		->toJson();
    }

    public function show(Request $request, $id){
        try {
            $data = MoveRequest::with(['user'])->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return $this->error('찾는 정보가 없습니다.',404);
        } catch(Exception $e ){
            return $this->error( $e->getMessage());
        }
        return $this->success($data);
    }

    public function updateFrontShow(Request $request, $id){
        try {
            $data = MoveRequest::findOrFail($id);
            $data->use_front = $request->is_use_front;
            $data->save();
            \Cache::store('file')->forget( "front_data_cache");
        } catch (ModelNotFoundException $exception) {
            return $this->error('찾는 정보가 없습니다.',404);
        } catch(Exception $e ){
            return $this->error( $e->getMessage());
        }
        return $this->success(['id'=>$data->id, 'use_front'=>$data->use_front]);
    }
    public function update(Request $request, $id){
        try {
            $data = MoveRequest::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return $this->error('찾는 정보가 없습니다.',404);
        } catch(Exception $e ){
            return $this->error( $e->getMessage());
        }

        $formValidate = $request->validate([
			'move_date'=>'bail|required|date',
            'req_status'=>'bail|required',
            'from_floor'=>'bail|required|numeric',
            'to_floor'=>'bail|required|numeric',
            'keep'=>'bail|nullable',
        ],[
            "move_type.*"=>"이사유형(가정이사, 원룸이사등)을 선택해주세요",
			"move_date.*"=>"이사일을 선택해주세요",
            'req_status.*'=>'진행상태를 선택해주세요',
            "from_zip.*"=>"출발지 주소를 검색해주세요",
            "from_floor.*"=>"출발지 층수를 선택해주세요",
            "to_zip.*"=>"도착지 주소를 검색해주세요",
            "to_floor.*"=>"도착지 층수를 선택해주세요",

            "to_data.*"=>"출발지 주소를 검색해주세요",
            "from_data.*"=>"도착지 주소를 검색해주세요",
        ],[]
        );
        $data->update( $formValidate);
        \Cache::store('file')->forget( "front_data_cache");
        return $this->success();
    }
    public function destroy($id){
        try {
            $data = MoveRequest::findOrFail($id);
            $data->delete();
        } catch (ModelNotFoundException $exception) {
            return $this->error('찾는 정보가 없습니다.',404);
        } catch(Exception $e ){
            return $this->error( $e->getMessage());
        }
        \Cache::store('file')->forget( "front_data_cache");
        return $this->success();
    }
}