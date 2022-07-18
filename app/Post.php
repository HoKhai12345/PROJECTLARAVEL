<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'post';
    protected $fillable = [
        'title' , 'content'
    ];

    function getDataByCategoryId ($categoryId) {
        dd($categoryId);
    }
}
