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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('booking', \App\Http\Controllers\API\BookingController::class);
Route::resource('cinema', \App\Http\Controllers\API\CinemaController::class);
Route::get('/test', [\App\Http\Controllers\API\CinemaController::class, 'searchFromRoom']);
Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [\App\Http\Controllers\API\AuthController::class, 'login']);
    Route::post('/signup', [\App\Http\Controllers\API\AuthController::class, 'signup']);
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/logout', [\App\Http\Controllers\API\AuthController::class, 'logout']);
        Route::get('/user', [\App\Http\Controllers\API\AuthController::class, 'getUser']);
    });
});
