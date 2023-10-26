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
}