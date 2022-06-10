<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PassportAuthController;
use Api\ProductController;
use App\Http\Controllers\Api\NewsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::get('/user', [UserController::class, 'index']);

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
Route::get('news/search' , [NewsController::class , 'search']);
Route::get('news/newsDetail' , [NewsController::class , 'detailPost']);
Route::get('news/countPostCate' ,[NewsController::class , 'countPostCate'] );
Route::get('news/{categoryId}' , [NewsController::class , 'index'] );
Route::get('news/listNews/{categorySlugs}' , [NewsController::class , 'listNewsByCate']);
Route::middleware(['auth:api'])->group(function () {
    Route::get('get-user', [PassportAuthController::class, 'userInfo']);

    Route::resource('products', ProductController::class);

});
