<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'order';
    protected $fillable = [
        'id' , 'name' , 'message'
    ];

    function getDataByCategoryId ($categoryId) {
        dd($categoryId);
    }
}
