<?php
namespace App\Http\Controllers\Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Jobs\SendWelcomeEmail;
class RegisterController extends Controller
{
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $job = (new SendWelcomeEmail($user))->delay(Carbon::now()->addMinutes(10));
        dispatch($job);
        return $user;
    }
}
