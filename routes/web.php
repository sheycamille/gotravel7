<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});*/

Route::get('/', 'FrontController@welcome')->name('welcome');
Route::get('/terms', 'FrontController@terms')->name('terms');
Route::get('/faqs', 'FrontController@faqs')->name('faqs');
Route::get('/about', 'FrontController@about')->name('about');
Route::get('/sitemap', 'FrontController@sitemap')->name('sitemap');
Route::get('/rides/persons', 'RideController@getAllRides')->name('get_all_rides');
Route::get('/support', 'FrontController@support')->name('support');
Route::get('/popular/routes', 'FrontController@popular_routes')->name('popular-routes');
Route::get('/switch/language/{lang}', 'FrontController@switch_language')->name('switch-language');
Route::get('/switch/transport/{type}', 'FrontController@switch_transport_type')->name('switch-transport-type');
Route::get('/forget-password', 'ForgotPasswordController@ForgetPasswordForm')->name('forget.password');
Route::post('/forget-password', 'ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post');
Route::get('/reset-password/{token}', 'ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
Route::post('/reset-password', 'ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');



Route::middleware('auth')->group(function() {    
//management routes starts here
Route::group(['prefix' => 'admin', 'middleware' => ['guest'],],function(){
    Route::get('/home', 'AdminController@dashboard')->name('dash-home');
    Route::get('/users-list', 'AdminController@getUsers')->name('fetchusers');
    Route::get('/drivers-list', 'UserController@driversList')->name('get-drivers');
    Route::get('/passengers-list', 'UserController@passengersList')->name('get-passengers');
    Route::get('/rides-list', 'AdminController@ridelist')->name('mrides'); // yajra ridelist
    Route::get('/vehicle-list', 'VehicleController@vehiclesList')->name('fetchvehicles');
    Route::get('/update-profile', 'AdminController@profileEdit')->name('editprofile');
    Route::post('/profile-update', 'AdminController@profileUpdate')->name('update-p');
    Route::get('/user/block/{id}', 'AdminController@uBlock')->name('blockuser');
    Route::get('/user/unblock/{id}', 'AdminController@uUnblock')->name('unblockuser');
    Route::post('/update/{id}', 'AdminController@updateUser')->name('updateuser');
    Route::post('/store', 'RideController@store')->name('add-ride');
    Route::post('/update/ride/{id}', 'RideController@update')->name('updateride');
    Route::post('/delete/{id}', 'RideController@delete')->name('deleteride');
    Route::post('/vehicle/store', 'VehicleController@store')->name('store-v');
    Route::post('/vehicle/update/{id}', 'VehicleController@update')->name('update-v');
    Route::post('/vehicle/delete/{id}', 'VehicleController@destroy')->name('delete-v');
    Route::get('/changepassword', 'AdminController@changePassword')->name('changepass');
    Route::post('/updatepassword', 'AdminController@updatePassword')->name('updatepass');

});

//users routes starts here
Route::group(['prefix' => 'user'], function (){
    Route::get('/', 'UserController@index')->name('my-profile');
    Route::get('/dashboard', 'UserController@dashboard')->name('user.dashboard');
    Route::get('/edit', 'UserController@edit')->name('edit-profile');
    Route::post('/update', 'UserController@update')->name('update-profile');
    Route::post('/change-password', 'UserController@changePassword')->name('reset_password');
    Route::get('/rides', 'UserController@rides')->name('my-rides');
    Route::get('/journeys', 'UserController@journeys')->name('my-journeys');
    Route::get('/vehicles', 'UserController@vehicles')->name('my-vehicles');

});

//everything about rides management starts here
Route::group(['prefix' => 'ride'], function () {
    Route::get('/', 'RideController@store')->name('store-rides');
    //Route::get('/', 'RideController::class,'search')->name('rides');
    Route::get('/create/{type?}', 'RideController@create')->name('create-ride');
    Route::post('/store', 'RideController@store')->name('store-ride');
    //Route::get('/details/{id}', 'RideController::class,'details')->name('details-ride');
    Route::get('/edit/{id}', 'RideController@edit')->name('edit-ride');
    Route::post('/update/{id}', 'RideController@update')->name('update-ride');
    //Route::post('/update/{id}', 'RideController@update')->name('update-ride');
    Route::post('/delete/{id}', 'RideController@delete')->name('delete-ride');
    Route::post('/request-to-pay/{id}', 'RideController@momoRequestToPay')->name('request-to-pay');
    Route::get('/join/', 'RideController@join')->name('join');
    Route::get('/check-transaction-status/{id}', 'RideController@checkTransactionStatus')->name('trans-status');
    Route::get('/cancel-booking{id}', 'RideController@cancelBooking')->name('cancel-booking');
});

});

//rides routes that don't need auth
Route::get('search-ride/{type?}', 'RideController@search')->name('rides');
Route::get('rides/ride-list', 'RideController@getAllRides')->name('get-all-rides');
Route::get('rides/ride-details/{id}', 'RideController@details')->name('details-ride');


Route::group(['prefix' => 'how'], function () {
    Route::get('/ridesharing/works', 'FrontController@ridesharing_works')->name('how-ridesharing-works');
    Route::get('/ridesharing/safety', 'FrontController@ridesharing_safety')->name('ridesharing-safety');
    Route::get('/ridesharing/points', 'FrontController@ridesharing_points')->name('ridesharing-points');
    Route::get('/ridesharing/tips', 'FrontController@ridesharing_tips')->name('ridesharing-tips');
    Route::get('/offer_lift/works', 'FrontController@offer_lift_works')->name('how-offer-lift-works');
    Route::get('/offer_lift/guidelines', 'FrontController@offer_lift_guidelines')->name('offer-lift-guidelines');
    Route::get('/offer_lift/regulation', 'FrontController@offer_lift_regulation')->name('offer-lift-regulation');
});