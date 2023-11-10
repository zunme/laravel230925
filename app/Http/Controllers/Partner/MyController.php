<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Events\PresenceEvent;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use DataTables;
use DB;

use App\Models\MoveRequest;

class MyController extends Controller
{
    public function matching( Request $request){
        $user = \Auth::guard('partner')->user();
        $data = MoveRequest::select(
            'move_requests.id','move_requests.move_type','move_requests.req_status','move_requests.move_date',
            'move_requests.name','move_requests.tel',
            'move_requests.from_sido','move_requests.from_sigungu','move_requests.from_address','move_requests.from_floor',
            'move_requests.to_sido','move_requests.to_sigungu','move_requests.to_address','move_requests.to_floor',
            'move_requests.keep','move_requests.created_at'
            )
            ;
        $data->join('move_req_matchings', function($q) use($user) {
            return $q->on( 'move_requests.id','=','move_req_matchings.move_request_id')
                ->where( 'partner_id', '=' , $user->id);
        });

        if( $request->searchstr && $request->searchtype){
            $data->where($request->searchtype , 'like',"%{$request->searchstr}%");
        }
        if( $request->move_date ){
            $data->whereDate('move_requests.move_date',$request->move_date);
        }
        if( $request->created_at ){
            $data->whereDate('move_requests.created_at',$request->created_at);
        }

        $data->whereDate( 'move_requests.move_date' , '>=', carbon::now()->subMonth() )
            ->whereIn('req_status',['Ready','Matching']);

        return DataTables::eloquent($data)
            ->toJson();
    }
}