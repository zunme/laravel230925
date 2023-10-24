<?php

namespace App\Listeners;

use App\Events\MoveReqEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;

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
            return;
        }
        else if( $data->created_at <= Carbon::now()->setTimezone('Asia/Seoul')->subDays(2) ) return ;
        else if( $data->move_date <= Carbon::now()->setTimezone('Asia/Seoul') ) return;

        \Log::info("sendMessage");
    }
}
