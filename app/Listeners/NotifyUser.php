<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserMail;

class NotifyUser
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
     * @param  PostCreated  $event
     * @return void
     */
    public function handle(PostCreated $event)
    {
        //
        $users = User::get();
        foreach ($users as $user){
            Mail::to("0917388156ab@gmail.com")->send(new UserMail($event->post));
        }
    }
}
