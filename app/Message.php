<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'message';
    protected $fillable = [
        'author' , 'message'
    ];

    function findByData ($likeAuthor,$limit) {

    }
}
