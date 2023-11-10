<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Auth;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\User;
use App\Models\MoveRequest;

class MoveController extends Controller
{
    public function store(Request $request){
        $user = Auth::guard('web')->user();
        $formValidate = $request->validate([
            'move_type'=>'bail|required',
			'move_date'=>'bail|required|date',
            'from_zip'=>'bail|required|numeric',
            'from_address'=>'bail|required|string',
            'from_floor'=>'bail|required|numeric',
            'to_zip'=>'bail|required|numeric',
            'to_address'=>'bail|required|string',
            'to_floor'=>'bail|required|numeric',
            'keep'=>'bail|nullable',
            'to_data'=>'bail|required|json',
            'from_data'=>'bail|required|json',
        ],[
            "move_type.*"=>"이사유형(가정이사, 원룸이사등)을 선택해주세요",
			"move_date.*"=>"이사일을 선택해주세요",
            "from_zip.*"=>"출발지 주소를 검색해주세요",
            "from_floor.*"=>"출발지 층수를 선택해주세요",
            "to_zip.*"=>"도착지 주소를 검색해주세요",
            "to_floor.*"=>"도착지 층수를 선택해주세요",

            "to_data.*"=>"출발지 주소를 검색해주세요",
            "from_data.*"=>"도착지 주소를 검색해주세요",
        ],[]
        );
        $to_data = json_decode( $formValidate['to_data'], true);
        $from_data = json_decode( $formValidate['from_data'], true);

        $formValidate['from_sido'] = $from_data['sido'];
        $formValidate['from_sigungu'] = $from_data['sigungu'];
        $formValidate['from_siCode'] = substr($from_data['sigunguCode'],0,2);
        $formValidate['from_sigunguCode'] = $from_data['sigunguCode'];
        $formValidate['from_bcode'] = $from_data['bcode'];

        $formValidate['to_sido'] = $to_data['sido'];
        $formValidate['to_sigungu'] = $to_data['sigungu'];
        $formValidate['to_siCode'] = substr($to_data['sigunguCode'],0,2);
        $formValidate['to_sigunguCode'] = $to_data['sigunguCode'];
        $formValidate['to_bcode'] = $to_data['bcode'];

        /* TODO 재매칭 sido & gungu */
        /*
        $tempfrom = getMoveDong( $formValidate['from_bcode'], 'from');
        if( $tempfrom ) {
            $formValidate = array_merge( $formValidate, $tempfrom);
        }
        $tempfrom = getMoveDong( $formValidate['to_bcode'], 'to');
        if( $tempfrom ) {
            $formValidate = array_merge( $formValidate, $tempfrom);
        }
        */

        if(  $request->ispop=='false' && (!$request->name || !$request->tel) ){
            return $this->success(["from"=>$formValidate],'Unauthorized');
        }
        if( !$user ){
            $userinfo = $request->validate([
                    'name'=>'bail|required|string',
                    'tel'=>'bail|required|string',
                ],[
                    "name.*"=>"이름을 적어주세요",
                    "move_date.*"=>"전화번호를 적어주세요",
                ],[]
            );
        }else {
            $userinfo = [
                'name'=>$user->name,
                'tel'=>$user->tel
            ];
        }
        
        $agree = $request->validate([
            'agree1'=>'bail|required|in:true',
            'agree2'=>'bail|required|in:true',
            'agree3'=>'bail|required|in:true',
            'agree4'=>'bail|nullable|in:true,false',
        ],[
            "agree1.*"=>"필수사항에 동의해주세요",
            "agree2.*"=>"필수사항에 동의해주세요",
            "agree3.*"=>"필수사항에 동의해주세요",
            "agree4.*"=>"잘못된 동의 값입니다.",
        ],[]
    );

        $dup = MoveRequest::where(
            [
                'tel'=>$userinfo['tel'],
                'from_bcode'=>$formValidate['from_bcode'],
                'to_bcode'=>$formValidate['to_bcode'],
                'move_date'=>$formValidate['move_date'],
            ]
        )->first();
        abort_if( $dup ,422,'이미 이사정보를 등록하셨습니다.');
        $ins = array_merge( $formValidate, [
            'user_id'=> $user ? $user->id : null,
            'name'=>$userinfo['name'],
            'tel'=>$userinfo['tel'],            
            'agree'=>$agree['agree4']=='true' ? 'Y':'N',
        ]);
        MoveRequest::create($ins);
        if( !$user ) return $this->success(['login_need'=>true, 'data'=>$formValidate]);
        else return $this->success();
    }
}