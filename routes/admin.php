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
    Route::resource('logins', 'Admin\LoginController');
    Route::delete('logout', 'Admin\LoginController@out');
    Route::resource('auth/menu/availables', 'Admin\AdminMenuAvailableController');
    // 验证权限
    Route::group(['middleware' => ['AdminCheck']], function () {
        Route::resource('auth/users', 'Admin\AdminUserController');
        Route::resource('auth/roles', 'Admin\AdminRoleController');
        Route::resource('auth/permissions', 'Admin\AdminPermissionController');
        Route::resource('auth/role/permissions', 'Admin\AdminRolePermissionController');
        Route::resource('auth/menus', 'Admin\AdminMenuController');
        Route::resource('article/categorys', 'Admin\ArticleCategoryController');
        Route::resource('articles', 'Admin\ArticleController');
        Route::resource('article/tags', 'Admin\ArticleTagController');
        Route::resource('auth/permission/menus', 'Admin\AdminPermissionMenuController');
        Route::resource('auth/user/selfs', 'Admin\AdminUserSelfController');
    });
});
