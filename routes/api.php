<?php

use Illuminate\Http\Request;

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


Route::group(['middleware' => 'cors'], function () {
    Route::get('hello','Api\TestController@index');

    //需要验证session的
    Route::group(['middleware' => ['JwtAuth']], function () {

        //前台api
        Route::group(['middleware' => ['ApiCheck']], function () {
            //Route::resource('users', 'Api\UserController');
        });

        //管理平台api
        Route::group(['prefix' => 'admin'], function () {
            Route::resource('login', 'Admin\LoginController');
            Route::delete('logout', 'Admin\LoginController@out');

            Route::group(['middleware' => ['AdminCheck']], function () {

            });
        });


    });
});




//前台微信
//Route::any('wechat', 'Api\WechatController@serve');
//Route::any('wechat/auth', 'Api\WechatController@auth');





