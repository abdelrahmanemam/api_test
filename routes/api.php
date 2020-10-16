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


Route::group(['namespace' => 'API', 'prefix' => '/user'],function (){

    Route::get('error', function (){
        return response()->json(['error' => 'unauthenticated']);
    })->name('error');


//    user auth
    Route::post('login', 'LoggingController@login')->name('login');
    Route::post('register', 'RegisterController@register')->name('register');

//    admin auth
    Route::post('admin-login', 'LoggingController@adminLogin')->name('admin.login');
    Route::post('admin-register', 'AdminRegisterController@register')->name('admin.register');


//    protected
    Route::group(['middleware' => 'auth:api'], function(){
        Route::post('refresh', 'UserController@refresh')->name('refresh');
        Route::post('user-details', 'UserController@user')->name('user.details');
        Route::post('admin-details', 'AdminController@admin')->name('admin.details');
        Route::post('logout','UserController@logout')->name('logout');
    });
});



