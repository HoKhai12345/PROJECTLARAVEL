<?php

namespace App\Events;

use App\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrderShoppingCart
{
    use SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function __construct(Order $order)
    {
        Log::channel('laravelLogDemo')->info("$order");
        $this->order = $order;
    }
}
