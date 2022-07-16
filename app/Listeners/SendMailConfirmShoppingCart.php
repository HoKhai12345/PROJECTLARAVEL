<?php

namespace App\Listeners;
use App\Order;

use App\Events\OrderShoppingCart;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;

class SendMailConfirmShoppingCart
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderShoppingCart  $event
     * @return void
     */
    public function handle(OrderShoppingCart $event)
    {
        Log::channel("laravelLogDemo")->info("HELLO__" . $event);
//        Order::where('id', $event)
//            ->update(['message' => new Date()]);
//         return 1;
        // Access the order using $event->order...
    }
}
