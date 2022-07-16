<?php
namespace App\Http\Controllers;
use App\Events\RedisEvent;
use App\Http\Controllers\Controller;
use App\Repositories\Message\Message;
use Faker\Core\Number;
use App\Repositories\Message\MessageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RedisController extends Controller
{

    public function __construct()
    {
        $this->messageModel = new MessageRepository();
    }

    public function index($limit)
    {
         $message = $this->messageModel->getMessage($limit);
         return view("message" , compact('message' , 'limit'));
    }
    public function sendMessage(Request $request){
        try {
            $message = $this->messageModel->addMessage($request->all());
            event(
                $e = new RedisEvent($message)
            );
            return redirect()->back();
        }catch (\Exception $err){
            Log::info("$err");
        }

    }
}
