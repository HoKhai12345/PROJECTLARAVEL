<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RedisController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/message/{limit}' ,[RedisController::class, 'index'] );
Route::get('/count/lineFile' , function (){
    $folder = "D:\CDRVINA";
    $countRecord = 0;
    foreach (glob($folder . "/*.txt") as $filename) {
        $so_dong = count(file($filename));
        $countRecord += $so_dong;
    }
    echo $countRecord;
//    $file = basename($_SERVER['PHP_SELF']);
//    $so_dong = count(file($file));
//    echo "Có $so_dong dòng trong $file"."<br>";
});
Route::post('/message/{limit}' , [RedisController::class , 'sendMessage']);
Route::get('/order/{orderId}' , [OrderController::class, 'ship']);
Route::get('/dashboard' , [\App\Http\Controllers\PostController::class , 'formAdd'])->middleware('auth');
Route::post('/dashboard' , [\App\Http\Controllers\PostController::class , 'store'])->middleware('auth');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
