<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\MoveRequest;

class MoveReqEvent
{
    //use Dispatchable, InteractsWithSockets, SerializesModels;
    use SerializesModels;
    public $item;
    public function __construct(MoveRequest $move)
    {
        $this->item = $move;
        \Log::info( 'created');
    }
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
