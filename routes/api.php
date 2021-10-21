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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * 学生登录注册模块
 */
Route::prefix('user')->group(function () {
    Route::post('login', 'LoginController@login'); //学生登录
    Route::post('logout', 'LoginController@logout'); //学生退出登录
    Route::post('registered', 'LoginController@registered'); //学生注册
});//--pxy
/**
 * 辅导员登录注册模块
 */
Route::prefix('teacher')->group(function () {
    Route::post('login', 'TeacherloginController@login'); //辅导员登录
    Route::post('logout', 'TeacherloginController@logout'); //辅导员退出登录
    Route::post('registered', 'TeacherloginController@registered'); //辅导员注册
});//--pxy
