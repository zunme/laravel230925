<?php
namespace App\Classes;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
//use GuzzleHttp\Client;
use Exception;

use App\Models\PaymentCardLog;
use App\Events\PresenceEvent;

class Sms{
	protected $http;
	protected $sender;
	public $isTest;
    
    protected $lmsSubject;
    protected $msg_type;
    protected $msg;
    protected $user_id;
    protected $key;
    
	public function __construct()
    {
        $this->httpClient();
		$this->sender = '01024460120';
		$this->isTest = false;
        $this->lmsSubject = '2424-2424';
        $this->msg_type = 'SMS';
        $this->user_id = "onoffkorea636";
        $this->key="wybhb9ap91phrkf2eenygjnr9ohn5g37";
    }
    protected function httpClient()
    {
        return $this->http ?: $this->http = Http::timeout(5);
    }
    public function setMsg(String $msg){
        $this->msg = $msg;
		return $this;
    }
	public function send($tel , $msg=null){
		$url = 'https://apis.aligo.in/send/';
		//$url = 'http://oksusumarket.co.kr/post.php';
		$arr = ['tel'=>'01025376460','msg'=>'test.',];

        if( !$tel) throw new \Exception ('받으실 분의 전화번호가 없습니다.');
        else if( !$msg && !$this->msg) throw new \Exception ('SMS 메세지가 없습니다.');

		$sms['user_id'] = $this->user_id; // SMS 아이디
		$sms['key'] = $this->key;
		$sms['msg'] = ($msg) ? $msg : $this->msg;
		$sms['receiver'] = $tel;
		$sms['destination'] = $tel;
		$sms['sender'] = $this->sender;
		$sms['rdate'] = '';
		$sms['rtime'] = '';
		$sms['testmode_yn'] = $this->isTest ? 'Y' : 'N';
		$sms['title'] = $this->lmsSubject ;
		$sms['msg_type'] = $this->msg_type ;
        try{
            $response = $this->http->asForm()->post( $url, $sms);
            if( $response->successful() ){
                $res = $response->json();
                if( $res['result_code'] =='1') return true;
                else {
                    \Log::error('SMS ERROR', ['res'=>$res]);
                    return false;
                }
            }else {
                return false;
            }
        }catch (Exception $e){
            return false;
        }
	}
	
}