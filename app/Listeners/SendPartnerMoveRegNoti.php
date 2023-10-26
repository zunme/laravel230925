<?php

namespace App\Listeners;

use App\Events\MoveReqEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;

use App\Models\Partner;
use App\Models\MoveReqMatching;

class SendPartnerMoveRegNoti implements ShouldQueue
{
	public $connection = 'database';
	public $queue = 'default';
	public $delay = 1;

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MoveReqEvent $event): void
    {
        \Log::info("Listened", ['data'=>$event->item ]);
        $data = $event->item;

        
        if( !$data->user_id  && !$data->tel) {
            \Log::info( "pass noti : no user data");
            // TODO
            //return;
        }
        else if( $data->created_at <= Carbon::now()->setTimezone('Asia/Seoul')->subDays(2) ) return ;
        else if( $data->move_date <= Carbon::now()->setTimezone('Asia/Seoul') ) return;

        $partners = Partner::select('partners.id')->where('userstatus','confirmed');
        if( !config('site.use_sigungu',false) ){
            $code = getSiGunGuCode($data->from_bcode,'sido');
            $partners->join('partner_areas', function($q) use ($code){
                $q->on('partners.id','=','partner_areas.partner_id')
                    ->where([
                        'avail_siCode'=>$code,
                        'is_use'=>'Y'
                    ])
                    ->whereNull('avail_sigunguCode');
            });
        }else{
            $code = getSiGunGuCode($data->from_bcode,'gungu');
            $partners->join('partner_areas', function($q) use ($code){
                $q->on('partners.id','=','partner_areas.partner_id')
                    ->where([
                        'avail_sigunguCode'=>$code,
                        'is_use'=>'Y'
                    ])
                    ->whereNotNull('avail_siCode');
            });
        }
        $partner_ids = $partners->groupBy('partners.id')->get();

        $data->matching_cnt=$partner_ids->count();
        $data->noti = 'P';
        $data->save();

        foreach( $partner_ids as $row){
            $dup = MoveReqMatching::where([
                'move_request_id'=>$data->id,
                'partner_id'=>$row->id,
            ])->count();
            if( $dup == 0 ){
                $matching = MoveReqMatching::create([
                    'move_request_id'=>$data->id,
                    'partner_id'=>$row->id,
                ]);
                $this->sendMessage($matching);
            }
        }
        $data->noti = 'Y';
        $data->save();
        \Log::info("sendMessage");
    }

    protected function sendMessage($matching){

        $matching->notied='Y';
        $matching->save();
    }
}
