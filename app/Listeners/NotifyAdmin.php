<?php

namespace App\Listeners;

use App\Events\PostCreate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminMail;

class NotifyAdmin extends Mailable implements ShouldQueue
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
     * @param  PostCreate  $event
     * @return void
     */
    public function handle(PostCreate $event)
    {
        //
        sleep(4);
        Log::channel('laravelLogDemo')->info($event->post);
//        Mail::to('0917388156ab@gmail.com')->send(new AdminMail($event->post));
    }
}
