<?php
namespace App\Repositories\Message;

use App\Repositories\RepositoryInterface;

interface MessageRepositoryInterface extends RepositoryInterface
{
    //ví dụ: lấy tin nhắn
    public function getMessage($limit);
}
