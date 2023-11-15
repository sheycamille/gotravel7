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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'API\AuthenticationController@register');
Route::post('login', 'API\AuthenticationController@login');
Route::post('verify', 'API\AuthenticationController@emailVerify');
Route::post('reset', 'API\PasswordResetController@create');
Route::post('find', 'API\PasswordResetController@find');
Route::post('reset', 'API\PasswordResetController@reset');

//Route::post('login_grant', 'API\AuthenticationController@loginGrant');
   
Route::middleware('auth:api')->group( function () {
    //Route::resource('products', 'API\ProductController');
});
