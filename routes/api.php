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

Route::get('routes', 'API\RideController@getRoutes');

Route::middleware('auth:api')->group(function () {

    Route::group(['prefix' => 'user'], function(){
        Route::get('get-user', 'API\UserController@getUser');
        Route::post('change-password', 'API\UserController@changePassword');
        Route::put('edit-profile', 'API\UserController@update');
    });

    Route::group(['prefix' => 'ride'], function(){

        Route::post('create', 'API\RideController@create');
        Route::get('rides-near', 'API\RideController@getRidesNextTwoDays');
        Route::get('rides-later', 'API\RideController@getRidesLater');
        Route::post('delete/{id}', 'API\RideController@deleteRide');
        Route::post('cancel/{id}', 'API\RideController@cancelRide');
        Route::post('book/{id}', 'API\RideController@bookRide');
        Route::get('my-rides', 'API\RideController@myRides');
        Route::get('my-rides/detail/{id}', 'API\RideController@getRideDetails');
        Route::get('my-bookings', 'API\RideController@myBookings');
        Route::post('search', 'API\RideController@searchRides');

        Route::post('request-to-pay/{id}', 'API\RideController@momoRequestToPay');
        Route::get('check-transaction-status/{id}', 'API\RideController@checkTransactionStatus');

        // Route::post('search/{type?}', 'API\RideController@search');
    });


    Route::group(['prefix' => 'booking'], function(){
        Route::post('book', 'API\BookingController@bookRide');
        Route::get('get-bookings', 'API\BookingController@getBookings');
        Route::post('cancel', 'API\BookingController@cancelBooking');
    });

    Route::get('get-payment-Methods', 'API\RideController@getPaymentMethod');
    
});


