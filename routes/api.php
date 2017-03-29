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

Route::get('test', 'Api\TestController@index');

//需要验证session的
Route::group(['middleware' => ['JwtAuth']], function () {

    //微信授权接口
    //Route::any('wechat/auth', 'Api\WechatController@auth');

    //前台api
    Route::group(['middleware' => ['ApiCheck']], function () {
        //Route::resource('users', 'Api\UserController');

    });
});

//微信消息回调接口
//Route::any('wechat', 'Api\WechatController@index');

//socket接口路由
/*Route::group(['middleware' => ['JwtAuth']], function () {

    Route::group(['middleware' => ['ApiCheck']], function () {
        Route::get('socket/token', 'Api\SocketController@token');//登录获取token
    });
});
Route::post('socket/check_token', 'Api\SocketController@check_token');*/
