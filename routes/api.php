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

Route::middleware(['auth:api', 'checkLockedUser'])->group(function () {
    Route::resource('booking', \App\Http\Controllers\API\BookingController::class);
    Route::resource('product', \App\Http\Controllers\API\ProductController::class);
    Route::resource('payment', \App\Http\Controllers\API\PaymentController::class);
    Route::resource('recommend', \App\Http\Controllers\API\RecommendController::class);
    Route::resource('room', \App\Http\Controllers\API\RoomController::class);
    Route::resource('show', \App\Http\Controllers\API\ShowController::class);
    Route::resource('user', \App\Http\Controllers\API\UserController::class);
    Route::get('/product/filterName',[\App\Http\Controllers\API\ProductController::class,'filterName']);
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [\App\Http\Controllers\API\AuthController::class, 'login']);
    Route::post('/signup', [\App\Http\Controllers\API\AuthController::class, 'signup']);
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/logout', [\App\Http\Controllers\API\AuthController::class, 'logout']);
        Route::get('/user', [\App\Http\Controllers\API\AuthController::class, 'getUser']);
    });
});
