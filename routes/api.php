<?php

use Illuminate\Support\Facades\Route;


Route::group(["prefix" => "auth"], function () {
    Route::post('register', 'API\AuthenticationController@register');
    Route::post('login', 'API\AuthenticationController@login');
    Route::post('verify', 'API\AuthenticationController@emailVerify');
    Route::post('otp/resend', 'API\AuthenticationController@resendOtp');
    Route::post('find-account', 'API\PasswordResetController@findAccount');
    Route::post('reset-password', 'API\PasswordResetController@changePassword');
});

Route::group(['prefix' => 'ride'], function () {

    Route::post('search/{type?}', 'API\RideController@search');
    

});

Route::middleware('auth:api')->group(function () {

    Route::post('create-ride', 'API\RideController@create');
    Route::get('ride-details/{id}', 'API\RideController@rideDetails');
    Route::post('request-to-pay/{rideId}', 'API\RideController@momoRequestToPay');
    Route::get('check-transaction-status/{id}', 'API\RideController@checkTransactionStatus');

    Route::post('change-password', 'API\UserController@changePassword');

    Route::get('get-user', 'API\UserController@getUser');

    Route::get('get-routes', 'API\RideController@getRoutes');

    Route::post('logout', 'API\AuthenticationController@logout');
});


