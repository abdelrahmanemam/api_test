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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['namespace' => 'API', 'prefix' => '/user'],function (){

//    user auth
    Route::post('login', 'LoggingController@login')->name('login');
    Route::post('register', 'RegisterController@register');


//    admin auth

    Route::post('admin_login', 'LoggingController@adminLogin')->name('admin.login');
    Route::post('admin_register', 'AdminRegisterController@register');

    Route::group(['middleware' => 'auth:api'], function(){
        Route::post('user', 'UserController@user');
        Route::post('admin', 'AdminController@admin');
        Route::post('logout','UserController@logout');

    });
});



