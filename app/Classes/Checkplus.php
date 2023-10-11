<?php
namespace App\Classes;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Exception;

use App\Models\CheckplusLog;

class Checkplus{
    public function __construct(){
        $config = [
            'sitecode' => config('site.check.hp.SITECODE'),
            'sitepasswd' => config('site.check.hp.PASSWORD'),
            'cb_encode_path' => config('site.check.CPClient'),
            'returnurl'=>config('site.check.hp.returnurl'),
            'errorurl'=>config('site.check.hp.errorurl'),
            'reqseq' => Session::getId(),
            'authtype'=>'M',
            'customize'=>'',
        ];
        $this->config = $config;
    }
    public function setConfig($arr){
        foreach ( $arr as $id=>$val){
            $this->config[$id] = $val;
        }
    }
    public function getConfig(){
        return $this->config;
    }
    public function checkRetSeq( $retseq ){
        return $retseq === session('REQ_SEQ');
    }

    public function getEnc($reqseq=null){
        extract($this->config);
        session(['REQ_SEQ' => $reqseq]);

        $plaindata = "7:REQ_SEQ" . strlen($reqseq) . ":" . $reqseq .
        "8:SITECODE" . strlen($sitecode) . ":" . $sitecode .
        "9:AUTH_TYPE" . strlen($authtype) . ":". $authtype .
        "7:RTN_URL" . strlen($returnurl) . ":" . $returnurl .
        "7:ERR_URL" . strlen($errorurl) . ":" . $errorurl .
        "9:CUSTOMIZE" . strlen($customize) . ":" . $customize;
        $enc_data_str = "$cb_encode_path ENC $sitecode $sitepasswd $plaindata";
        $enc_data = `$cb_encode_path ENC $sitecode $sitepasswd $plaindata`;

        $returnMsg = "";

        if( $enc_data == -1 )
        {
            $returnMsg = "암/복호화 시스템 오류입니다.";
            $enc_data = "";
        }
        else if( $enc_data== -2 )
        {
            $returnMsg = "암호화 처리 오류입니다.";
            $enc_data = "";
        }
        else if( $enc_data== -3 )
        {
            $returnMsg = "암호화 데이터 오류 입니다.";
            $enc_data = "";
        }
        else if( $enc_data== -9 )
        {
            $returnMsg = "입력값 오류 입니다.";
            $enc_data = "";
        }
        return ( compact(['returnMsg','enc_data']));
    }

    public function getDesc($request){
        if (!$request->EncodeData) throw new Exception("입력값 오류");
        $enc_data = $request->EncodeData;

        if(preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match)) throw new Exception("입력 값 확인이 필요합니다 : ".$match[0]);
        if(base64_encode(base64_decode($enc_data))!=$enc_data) throw new Exception("입력 값 확인이 필요합니다");
        extract($this->config);

        $plaindata = `$cb_encode_path DEC $sitecode $sitepasswd $enc_data`;

        $log = null;
        $user = \Auth::guard('web')->user();
        $data = array();
        if ($plaindata == -1){
            $returnMsg  = "암/복호화 시스템 오류";
        }else if ($plaindata == -4){
            $returnMsg  = "복호화 처리 오류";
        }else if ($plaindata == -5){
            $returnMsg  = "HASH값 불일치 - 복호화 데이터는 리턴됨";
        }else if ($plaindata == -6){
            $returnMsg  = "복호화 데이터 오류";
        }else if ($plaindata == -9){
            $returnMsg  = "입력값 오류";
        }else if ($plaindata == -12){
            $returnMsg  = "사이트 비밀번호 오류";
        }else{
            $returnMsg ="";
            // 복호화가 정상적일 경우 데이터를 파싱합니다.
            $ciphertime = `$cb_encode_path CTS $sitecode $sitepasswd $enc_data`;	// 암호화된 결과 데이터 검증 (복호화한 시간획득)
        
            $data['requestnumber'] = $this->GetValue($plaindata , "REQ_SEQ");
            $data['responsenumber'] = $this->GetValue($plaindata , "RES_SEQ");
            $data['authtype'] = $this->GetValue($plaindata , "AUTH_TYPE");
            //$data['name'] = $this->GetValue($plaindata , "NAME");
            $data['name'] = urldecode($this->GetValue($plaindata , "UTF8_NAME")); //charset utf8 사용시 주석 해제 후 사용
            $data['birthdate'] = $this->GetValue($plaindata , "BIRTHDATE");
            $data['gender'] = $this->GetValue($plaindata , "GENDER");
            $data['nationalinfo'] = $this->GetValue($plaindata , "NATIONALINFO");	//내/외국인정보(사용자 매뉴얼 참조)
            $data['dupinfo'] = $this->GetValue($plaindata , "DI");
            $data['conninfo'] = $this->GetValue($plaindata , "CI");
			$data['mobileno'] = $this->GetValue($plaindata , "MOBILE_NO");
            $data['mobileco'] = $this->GetValue($plaindata , "MOBILE_CO");
            $data['user_id'] = $user ? $user->id : null;
            $data['session_data'] = session('REQ_SEQ');
            $data['ip'] = $request->ip();
            
            try{
                $log = CheckplusLog::create($data);
                if( !$this->checkRetSeq( $data['requestnumber'])) {
                    $log->etc = '인증세션 데이터가 동일하지 않습니다';
                    $log->save();
                    throw new Exception ('인증세션 데이터가 동일하지 않습니다. 잠시후에 다시 시도해주세요');
                }
                if( $user ){
                    $user->tel = $data['mobileno'];
                    $user->tel_verified_id = $log->id;
                    $user->save();
                }
            }catch(\Exception $e){
                throw new Exception ('인증도중 오류가 발생하였습니다. 잠시후에 다시 시도해주세요');
            }
        }
        if( $returnMsg !='') throw new Exception ($returnMsg);

        return ['msg'=>$returnMsg, 'data'=>$data,'log'=>$log];
    }

    protected function GetValue($str , $name) 
    {
        $pos1 = 0;  //length의 시작 위치
        $pos2 = 0;  //:의 위치

        while( $pos1 <= strlen($str) )
        {
            $pos2 = (int)strpos( $str , ":" , $pos1);
            $len = (int)substr($str , $pos1 , $pos2 - $pos1);
            try{
                $key = substr($str , $pos2 + 1 , $len);
            }catch (Exception $e){
                dd( $len);
            }
            $pos1 = $pos2 + $len + 1;
            if( $key == $name )
            {
                $pos2 = (int)strpos( $str , ":" , $pos1);
                $len = (int)substr($str , $pos1 , $pos2 - $pos1);
                $value = substr($str , $pos2 + 1 , $len);
                return $value;
            }
            else
            {
                // 다르면 스킵한다.
                $pos2 = (int)strpos( $str , ":" , $pos1);
                $len = (int)substr($str , $pos1 , $pos2 - $pos1);
                $pos1 = $pos2 + $len + 1;
            }            
        }
    }
}