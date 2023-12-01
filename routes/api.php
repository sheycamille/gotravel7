<?php

use App\Models\Ride;
use App\Models\RouteDirection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(["prefix" => "auth"], function () {
    Route::post('register', 'API\AuthenticationController@register');
    Route::post('login', 'API\AuthenticationController@login');
    Route::post('verify', 'API\AuthenticationController@emailVerify');
    Route::post('otp/resend', 'API\AuthenticationController@resendOtp');
    Route::post('find-account', 'API\PasswordResetController@findAccount');
    Route::post('reset-password', 'API\PasswordResetController@changePassword');
});

Route::middleware('auth:api')->group(function () {
    Route::group(['prefix' => 'user'], function(){
        Route::get('get-user', 'API\UserController@getUser');
    });

    Route::group(['prefix' => 'ride'], function(){
        Route::post('create', 'API\RideController@create');
        Route::get('rides', 'API\RideController@getRides');
        Route::get('details/{id}', 'API\RideController@rideDetails');
        Route::post('cancel/{id}', 'API\RideController@cancelRide');
        Route::post('book/{id}', 'API\RideController@bookRide');

        Route::post('request-to-pay/{id}', 'API\RideController@momoRequestToPay');
        Route::get('check-transaction-status/{id}', 'API\RideController@checkTransactionStatus');
    });

    
});

