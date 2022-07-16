<?php

namespace App\Events;
use App\Repositories\Message\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class RedisEvent implements ShouldBroadcast
{
    use SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function __construct($message)
    {
        Log::channel('laravelLogDemo')->info($message);
        $this->message = $message;
    }
    public function broadcastOn() {
        return ['chat'];
    }
    public function broadcastAs() {
        return "message";
    }
}
