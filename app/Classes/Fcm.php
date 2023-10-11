<?php 

namespace App\Classes;

use Exception;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use App\Models\User;
use App\Models\FcmToken;

class Fcm {
    public $SERVER_API_KEY;
    public $project_id;
    public function __construct(){
        $this->project_id = env('FCM_PROJECT_ID','oksusupay');
        try{
            $SERVER_API_KEY = \Cache::store('redis')->get('fcmauth1', function () {
                $path = base_path().'/'.env('FCM_PROJECT_CONFIG','google.config.json');
                $client = new \Google_Client();
                $client->setAuthConfig($path);
                $client->addScope("https://www.googleapis.com/auth/cloud-platform");
                $client->fetchAccessTokenWithAssertion();
                $accessToken = $client->getAccessToken();
                \Cache::store('redis')->put('fcmauth', $accessToken['access_token'], $accessToken['expires_in']-99);
                return $accessToken['access_token'];
            });
            $this->SERVER_API_KEY = $SERVER_API_KEY;
        }catch(\Exception $e){
            $this->SERVER_API_KEY = null;
        }
    }
    public function getAdminTokens() {
       return FcmToken::
		join('users', function ($q){
			$q->on( 'fcm_tokens.user_id','=','users.id')
			->where('users.authtype','=','admin')
			->whereNull('deleted_at')
			->where('userstatus','=','done');
		})
		->where('agree','Y')
		->pluck('token');
    }
    public function getUserTokens ($uid){
        $user = User::find( $uid);
        if( !$user ) return [];
        return FcmToken::where( 'user_id','=',$uid)->where('agree','Y')->pluck('token');
    }
    public function send ( $tokenArr, array $payload){
        if( !$this->SERVER_API_KEY) return;
        $data =[
            'message'=>[
				"token"=>'',
                "notification"=> [
                    "body"=> $payload['body'],
                    "title"=> $payload['title'],
                ],
				"data"=>['type'=>'','id'=>''],
            ]
        ];
        if ($tokenArr == 'admin'){
            $tokenArr = $this->getAdminTokens();
        }
        if( isset( $payload['data'] ) ){
            $temparr =[];
            foreach ( $payload['data'] as $key=>$val){
                $temparr[$key] = (string)$val;
            }
            $data['message']['data'] = $temparr;
        }
        if( $this->SERVER_API_KEY && count( $tokenArr ) > 0  ){
            foreach ( $tokenArr as $receiver_token){
                try{
                    $data['message']['token'] = $receiver_token;
                    $dataString = json_encode($data);
                    $headers = [
                        'Authorization: Bearer ' . $this->SERVER_API_KEY,
                        'Content-Type: application/json',
                    ];
                
                    $ch = curl_init();
                    $oldurl = "/fcm.googleapis.com/fcm/send";
                    $url = "fcm.googleapis.com/v1/projects/".$this->project_id."/messages:send";
                    curl_setopt($ch, CURLOPT_URL, 'https://'.$url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                            
                    $response = curl_exec($ch);
					curl_close($ch);
					if( $response ){
						$json_data = json_decode($response,true);
						if( isset($json_data['error'])  && $json_data['error']['code'] =='404'){
							FcmToken::where( 'token',$receiver_token)->delete();
						}
						\Log::info('fcmsend', $json_data);
					}
                } catch(\Exception $e){
						//\Log::info('fcmsend', ['error'=>$e->getMessage() ]);
                    ;
                }
            }
        }
    }
}