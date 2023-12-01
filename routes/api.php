<?php

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
    Route::post('create-ride', 'API\RideController@create');
    Route::get('ride-details/{id}', 'API\RideController@rideDetails');

    Route::get('get-user', 'API\UserController@getUser');

    //Route::post('logout', 'API\AuthenticationController@logout');
});

