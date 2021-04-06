<?php

use Illuminate\Support\Facades\Route;
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
Route::resource('booking',\App\Http\Controllers\RoomController::class);
Route::get('/test',[\App\Http\Controllers\CinemaController::class,'searchFromRoom']);
Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [\App\Http\Controllers\AuthController::class,'login']);
    Route::post('/signup', [\App\Http\Controllers\AuthController::class,'signup']);
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('/logout', [\App\Http\Controllers\AuthController::class,'logout']);
        Route::get('/user', [\App\Http\Controllers\AuthController::class,'user']);
    });
});
