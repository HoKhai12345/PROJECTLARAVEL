<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PassportAuthController;
use Api\ProductController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\RegisterController;
use Carbon\Traits\Date;
use Illuminate\Support\Facades\Log;


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
Route::get('test', function (Request $request){
    Log::debug('An informational message.');
    Log::info('Showing the user profile for user: ');
    Log::channel('laravelLogDemo')->info("Ok , test log thành công");
    $fp = fopen( '../storage/test.txt', 'w');//mở file ở chế độ write-only
    fwrite($fp, 'Xin chào!');
    fwrite($fp, date("Y/m/d H:I:s")
);
    fclose($fp);
    $file = $request->file('file');
    $a = $request->get('a');
    $validatedData = $request->validate([
        'file' => 'required|jpg,csv,txt,xlx,xls,pdf|max:2048',
    ]);
    $name = $request->file('file')->getClientOriginalName();
    $path = $request->file('file')->store('public/files');
    var_dump($file);
    var_dump($a);

});
Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
Route::get('news/search' , [NewsController::class , 'search']);
Route::get('news/newsDetail' , [NewsController::class , 'detailPost']);
Route::get('news/countPostCate' ,[NewsController::class , 'countPostCate'] );
Route::get('news/{categoryId}' , [NewsController::class , 'index'] );
Route::get('news/listNews/{categorySlugs}' , [NewsController::class , 'listNewsByCate']);
Route::get('sendMail' , [NewsController::class, 'create']);
Route::middleware(['auth:api'])->group(function () {
    Route::get('get-user', [PassportAuthController::class, 'userInfo']);

    Route::resource('products', ProductController::class);

});
Route::get("demoMiddleware",function (){
    echo 1;
})->middleware('auth.token');
