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

Route::prefix('student')->group(function () {
    Route::post('fillin', 'StudentController@fillin'); //学生填报
    Route::get('record', 'StudentController@record'); //历史记录
    Route::get('details', 'StudentController@details'); //详情
});//--echojoy
Route::prefix('teacher')->group(function () {
    Route::get('exhibit', 'TeacherController@exhibit'); //数据展示
    Route::get('approve', 'TeacherController@approve'); //教师审批
    Route::get('cassette', 'TeacherController@cassette'); //记录
});//--echojoy
Route::prefix('secretary')->group(function () {
    Route::get('data', 'SecretaryController@data'); //数据展示
    Route::get('audit', 'SecretaryController@audit'); //书记审核
    Route::get('leave', 'SecretaryController@leave'); //书记展示
});//--echojoy
Route::get('search', 'SecretaryController@search'); //搜索 //--echojoy
