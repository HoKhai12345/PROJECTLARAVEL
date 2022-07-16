<?php

namespace App\Http\Controllers;

use App\Order;
use App\Events\OrderShipped;
use App\Events\OrderShoppingCart;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Ship the given order.
     *
     * @param  int  $orderId
     * @return Response
     */
    public function ship($orderId)
    {
        Log::channel('laravelLogDemo')->info("Log từ OrderController");
        $order = Order::findOrFail($orderId);

        $emailJob = (new SendEmailJob())->delay(Carbon::now()->addSeconds(10));
        dispatch($emailJob);

        echo 'email sent';
        // Order shipment logic...
        event(new OrderShipped($order));

//        event(new OrderShoppingCart($order));
    }
}
