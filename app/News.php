<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'data_news_version_2_posts';
    protected $fillable = [
        'title' , 'name'
    ];

    function getDataByCategoryId ($categoryId) {
        dd($categoryId);
    }
}
