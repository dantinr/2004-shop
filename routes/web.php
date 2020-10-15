<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/info',function(){
    phpinfo();
});
Route::get('/', function () {
    echo date('Y-m-d H:i:s');die;
    return view('welcome');
});

Route::get('/test/upload1',"TestController@uploadImg");
Route::post('/test/upload2',"TestController@upload2");
Route::get('/test/md5',"TestController@testMd5");
Route::get('/test/goods',"TestController@goods");


Route::get('/hello','TestController@hello');
Route::get('/sql1','TestController@sql1');
Route::get('/u','TestController@u');

//Redis
Route::get('/redis1','TestController@redis1');
Route::get('/redis2','TestController@redis2');


//商品
Route::get('/goods/detail','GoodsController@detail');       //商品详情
Route::get('/goods/list','GoodsController@goodsList');       //商品列表

//用户
Route::get('/user/regist','UserController@regist');         //注册 前台
Route::post('/user/regist','UserController@registDo');         //注册 后台
Route::get('/user/login','UserController@login');         //登录 前台
Route::post('/user/login','UserController@loginDo');         //登录 后台
