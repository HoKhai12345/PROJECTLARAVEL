<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendEmailJob;

class EmailController extends Controller
{
//    public function sendEmail()
//    {
//        dispatch(new SendEmailJob());
//
//        echo 'email sent';
//    }
    public function sendEmail()
    {
        $emailJob = (new SendEmailJob())->delay(Carbon::now()->addSeconds(3));
        dispatch($emailJob);

        echo 'email sent';
    }

}
