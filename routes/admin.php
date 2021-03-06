<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| ADMIN Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/** 管理平台api **/

//需要验证session的
Route::group(['middleware' => ['JwtAuth']], function () {

    // 验证权限
    Route::group(['middleware' => ['AdminCheck']], function () {

    });
});
