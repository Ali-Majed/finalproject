<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//Route::get('tweets',[\App\Http\Controllers\Api\TweetController::class,'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();


});


Route::group(['prefix'=>'auth'],function (){
    Route::post('login',[\App\Http\Controllers\Auth\AuthController::class,'login']);
    Route::post('register',[\App\Http\Controllers\Auth\AuthController::class,'register']);
});
//Route::get('users',[\App\Http\Controllers\Api\UserController::class,'index']);


Route::group(['prefix'=>'v3','middleware'=> 'auth:api'],function (){


    Route::resource('users',\App\Http\Controllers\Api\UserController::class);
    Route::resource('tweets',\App\Http\Controllers\Api\TweetController::class);
    Route::get('tweets/{id}',[\App\Http\Controllers\Api\TweetController::class,'show']);


});


Route::get('tweets',[\App\Http\Controllers\Api\TweetController::class,'index']);

