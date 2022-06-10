<?php
namespace App\Repositories\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'data_news_version_2_posts';

    protected $fillable = [
        'name', 'detail'
    ];
}
