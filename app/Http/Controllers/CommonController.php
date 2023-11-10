<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Carbon\Carbon;
use Auth;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Holidays;
use App\Classes\Sondata;

use App\Models\DongCode;
use App\Models\Review;
use App\Models\MoveRequest;

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
        $data = \Cache::store('file')->remember( "sondata" , 3600 , function (){
            $obj = new Sondata();
            return $obj->getSonDays();
        });
		return response()->json($data);
	}
	public function checkAuthUser(Request $request){
		$user = Auth::guard('web')->user();
		if( $user ) return $this->success(['logined'=>true]);
		else return $this->error('',421,['logined'=>false]);
	}
	public function sigungu(){
        $sigungu = \Cache::store('file')->remember('sigungu_list',86400* 100, function(){
            $arr = [];
            foreach( config('customsido.simple') as $key=>$name){
                $arr[$key] = [
                    'sido_code'=>$key,
                    'short_name'=>$name,
                    'id'=>null,
                    'full_name'=>null,
                    'gungu'=>[]
                ];
            }
    
            $sido = DongCode::
            select( 'id','lawd_cd','sido_cd','sigungu_cd','sido','sgg' )
            ->where(['depth'=>'1', 'del_dt'=>''])->get();
            foreach( $sido as $row){
                $arr[ $row['sido_cd']]['id'] = $row->id;
                $arr[ $row['sido_cd']]['full_name'] = $row->sido;
            }
            $gungu = DongCode::
                select( 'id','lawd_cd','sido_cd','sigungu_cd','sido','sgg' )
                ->where(['depth'=>'2', 'del_dt'=>''])->orderBy('lawd_cd')->get()->toArray();
    
            foreach ( $gungu as $row){
                $arr[ $row['sido_cd']]['gungu'][] = $row;
            }
            $ret = [];
            foreach( $arr as $id=>$row){
                $ret[] = $row;
            }
            return $ret;
        });

        return $this->success($sigungu);
    }

    public function getReview(){
        return $this->success( $this->getReviewData() );
    }
    protected function getReviewData(){
        return Review::activefront()
        ->select('move_type','star_point','write_at','area','comment','created_at','move_date')
        ->addSelect( \DB::raw("REGEXP_REPLACE(name, '(?<=.{1}).', '*') AS name_marked"))
        ->orderBy('write_at','desc')->limit( config('site.front_review_cnt', 9))->get();
    }
    public function getReqList(){
        return $this->success( $this->getReqListData() );
    }
    protected function getReqListData(){
        return MoveRequest::select(
                \DB::raw("CONCAT( LEFT(`name`,1),'**') AS `name`"),
                'req_status','move_type','move_date',
                'from_sido','from_sigungu','from_siCode','to_siCode'
            )
            ->where('use_front','Y')
            ->limit(config('site.front_review_cnt', 20) )->get();
    }
    public function getFront(){
        return $this->success( $this->getFrontData() );
    }
    public function getFrontData(){
        $data = \Cache::store('file')->remember( "front_data_cache", 600, function(){
            $data = [];
            $data['review'] = $this->getReviewData();
            $data['req'] = $this->getReqListData();
            $data['cached'] = Carbon::now()->toDateTimeString();
            return $data;
        });
        return $data;
    }
}