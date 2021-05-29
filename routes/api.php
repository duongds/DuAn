<?php

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
    Route::resource('products', \App\Http\Controllers\API\ProductController::class);
    Route::resource('payments', \App\Http\Controllers\API\PaymentAPIController::class);
    Route::resource('rooms', \App\Http\Controllers\API\RoomController::class);
    Route::resource('shows', \App\Http\Controllers\API\ShowController::class);
    Route::resource('users', \App\Http\Controllers\API\UserController::class);
    Route::resource('show_rooms', \App\Http\Controllers\API\ShowRoomAPIController::class);
    Route::resource('categories', \App\Http\Controllers\API\CategoryAPIController::class);
    Route::resource('room_seats', \App\Http\Controllers\API\RoomSeatAPIController::class);
    Route::resource('payments', \App\Http\Controllers\API\PaymentAPIController::class);
    Route::prefix('select-list')->group(function () {
        Route::get('/product', [\App\Http\Controllers\API\ProductController::class, 'getSelectList']);
        Route::get('/show', [\App\Http\Controllers\API\ShowController::class, 'getSelectList']);
    });
    Route::prefix('save')->group(function(){
        Route::post('/image', [\App\Http\Controllers\API\ProductController::class, 'saveImage']);
    });
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [\App\Http\Controllers\API\AuthController::class, 'login']);
    Route::post('/signup', [\App\Http\Controllers\API\AuthController::class, 'signup']);
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/logout', [\App\Http\Controllers\API\AuthController::class, 'logout']);
        Route::get('/user', [\App\Http\Controllers\API\AuthController::class, 'getUser']);
    });
});
