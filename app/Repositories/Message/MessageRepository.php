<?php
//use Illuminate\Support\Facades\DB;
namespace App\Repositories\Message;

use App\Repositories\Message\MessageRepositoryInterface;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class MessageRepository extends BaseRepository implements MessageRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
        define('TABLE_NAME', 'message');
    }
    //lấy model tương ứng
    public function getModel()
    {
        return Message::class;
    }

    public function getMessage($limit)
    {
        if ($limit < 1){
            $limit = 5;
        }
        return $this->model->select("*")
               ->take($limit)
               ->orderBy('id', 'desc')
               ->get();
    }
    public function addMessage($request){
        Message::create($request);

    }
}
