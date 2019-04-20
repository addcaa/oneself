<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|-------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//登录视图
Route::get('login/index','Login\LoginController@index');
//注册
Route::get('login/register','Login\LoginController@register');
Route::post('login/add','Login\LoginController@add');

//发送邮箱
Route::post('login/mail','Login\LoginController@mail');

?>
