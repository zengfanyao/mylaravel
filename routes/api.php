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

    Route::get('admin/upload', 'Admin\UploadController@test');
    Route::any('admin/upload_callback', 'Admin\UploadController@uploadCallback');
    Route::any('admin/test', 'Admin\UploadController@test2');


    //需要验证session的
    Route::group(['middleware' => ['JwtAuth']], function () {

        //前台api
        Route::group(['middleware' => ['ApiCheck']], function () {
            Route::resource('users', 'Api\UserController');
            Route::resource('game/rooms', 'Api\GameRoomController');

            Route::post('websocket/get_token', 'Api\WebSocketController@getToken');
        });


        //管理平台api
        Route::group(['prefix' => 'admin'], function () {
            Route::resource('login', 'Admin\LoginController');
            Route::delete('logout', 'Admin\LoginController@out');

            Route::group(['middleware' => ['AdminCheck']], function () {
                Route::resource('game/room', 'Admin\GameRoomController');
                Route::resource('game/player', 'Admin\GamePlayerController');
                Route::resource('game/map', 'Admin\GameMapController');

                Route::post('websocket/get_token', 'Admin\WebSocketController@getToken');
            });


        });
    });
});

//前台wesocket
Route::group(['prefix' => 'ws'], function () {
    Route::post('check_token', 'Api\WebSocketController@checkToken');

    Route::post('game_player','Api\WebsocketController@getGamePlayer');
    Route::post('game_start','Api\WebsocketController@gameStart');
    Route::post('game_end','Api\WebsocketController@gameEnd');
    Route::post('game_finish','Api\WebsocketController@gameFinish');

    Route::group(['middleware' => ['ApiCheck']], function () {

    });
});

//管理平台wesocket
Route::group(['prefix' => 'ws/admin'], function () {
    Route::post('check_token', 'Admin\WebSocketController@checkToken');

    Route::group(['middleware' => ['AdminCheck']], function () {

    });
});


//前台微信
Route::any('wechat', 'Api\WechatController@serve');
Route::any('wechat/auth', 'Api\WechatController@auth');





