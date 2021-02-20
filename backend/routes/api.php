<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['guest:api']], function() {
    Route::post('login', '\App\Http\Controllers\Auth\LoginController@login');
    Route::post('login/refresh', '\App\Http\Controllers\Auth\LoginController@refresh');

    // Route::post('password/email', '\App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail');
    // Route::post('password/reset', '\App\Http\Controllers\Auth\ResetPasswordController@reset');

    // Route::post('register', '\App\Http\Controllers\Auth\RegisterController@register');
    
    Route::post('user', '\App\Http\Controllers\UserController@store');
    Route::post('user/find', '\App\Http\Controllers\UserController@find_email');
    Route::post('user/recovery_password', '\App\Http\Controllers\UserController@recovery_password');
    Route::post('user/verify_code', '\App\Http\Controllers\UserController@verify_code');
    Route::post('user/reset_password', '\App\Http\Controllers\UserController@reset_password');
});

Route::group(['middleware' => ['jwt']], function() {
    Route::post('logout', '\App\Http\Controllers\Auth\LoginController@logout');
    Route::get('me', '\App\Http\Controllers\Auth\LoginController@me');
    Route::apiResource('user', UserController::class)->except(['store']);
    Route::post('change_password', '\App\Http\Controllers\UserController@change_password');
});