<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(["prefix"=> "user"], function () {

    Route::group(["prefix"=> "auth"], function () {
        Route::post('register', 'API\AuthenticationController@register');
        Route::post('login', 'API\AuthenticationController@login');
        Route::post('verify', 'API\AuthenticationController@emailVerify');
        Route::post('otp/resend', 'API\AuthenticationController@resendOtp');

        Route::post('find-account', 'API\PasswordResetController@findAccount');
        Route::post('reset-password', 'API\PasswordResetController@changePassword');
    });

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::post('login_grant', 'API\AuthenticationController@loginGrant');
   
Route::middleware('auth:api')->group( function () {
    //Route::resource('products', 'API\ProductController');
});
