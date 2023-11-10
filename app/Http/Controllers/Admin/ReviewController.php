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

use App\Models\Review;
use App\Models\MoveRequest;

class ReviewController extends Controller
{
    public function index(Request $request){
        $data = Review::select('*');
        if( $request->searchstr && $request->searchtype){
            $data->where($request->searchtype , 'like',"%{$request->searchstr}%");
        }
        return DataTables::eloquent($data)
		->toJson();
    }
    public function show($review_id){
        $data = Review::find( $review_id );
        if( $data ) return $this->success($data);
    }
    function store(Request $request){
        if($request->move_request_id ){
            $cnt = Review::where([
                    'move_request_id'=>$request->move_request_id,
                    'is_view'=>'Y'
                ])->count();
            abort_if($cnt>0 ,422, '이미 리뷰가 작성되었습니다');
        }

        $formValidate = $request->validate([
            'user_id'=>'bail|nullable|integer',
			'move_request_id'=>'bail|nullable|integer',
            'move_type'=>'bail|required|integer',
            'name'=>'bail|required|string',
            'star_point'=>'bail|required|integer|min:1|max:5',
            'use_front'=>'bail|required|in:Y,N',
            'area'=>'bail|required|string',
            'move_date'=>'bail|required|date',
            'write_at'=>'bail|required|date',
            'comment'=>'bail|required|string',
        ],[
            "move_type.*"=>"이사유형(가정이사, 원룸이사등)을 선택해주세요",
			"write_at.*"=>"작성일을 선택해주세요",
            "star_point.*"=>"올바른 별점을 선택해주세요",
            "comment.*"=>"리뷰를 작성해주세요",
            "move_date.*"=>"이사일 작성해주세요",
            "area.*"=>"지역을 작성해주세요",
        ],[]
        );
        
        try{
            if(!$formValidate['write_at']) $formValidate['write_at'] = Carbon::now();
            Review::create($formValidate);
        }catch(Exception $e){
            return $this->error( $e->getMessage());
        }
        \Cache::store('file')->forget( "front_data_cache");
        return $this->success();
    }
    function update(Request $request, $id){
        $formValidate = $request->validate([
            'move_type'=>'bail|required|integer',
            'name'=>'bail|required|string',
            'star_point'=>'bail|required|integer|min:1|max:5',
            'move_date'=>'bail|nullable|date',
            'write_at'=>'bail|nullable|date',
            'write_at'=>'bail|nullable|date',
            'comment'=>'bail|required|string',
        ],[
            "move_type.*"=>"이사유형(가정이사, 원룸이사등)을 선택해주세요",
			"write_at.*"=>"작성일을 선택해주세요",
            "star_point.*"=>"올바른 별점을 선택해주세요",
            "comment.*"=>"리뷰를 작성해주세요",
            "move_date.*"=>"이사일 작성해주세요",
            "area.*"=>"지역을 작성해주세요",
        ],[]
        );
        try{
            if(!$formValidate['write_at']) $formValidate['write_at'] = Carbon::now();
            Review::where('id',$id)->update($formValidate);
        }catch(Exception $e){
            return $this->error( $e->getMessage());
        }
        \Cache::store('file')->forget( "front_data_cache");
        return $this->success();
    }
    public function reqshow($move_id){
        $data = Review::where('move_request_id','=',$move_id)->first();
        if( !$data ){
            $temp = MoveRequest::find( $move_id );
            if( !$temp ) abort('내용을 찾을 수 없습니다');
            $data=[
                "move_request_id"=>$move_id,
                "user_id"=>$temp->user_id,
                "name"=>$temp->name,
                "star_point"=>5,
                "move_type"=>$temp->move_type,
            ];
        }
        return $this->success($data);
    }
}