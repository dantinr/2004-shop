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
    //echo date('Y-m-d H:i:s');die;
    return view('welcome');
});

Route::get('/',"IndexController@home");         //网站首页

Route::get('/test/upload1',"TestController@uploadImg");
Route::post('/test/upload2',"TestController@upload2");
Route::get('/test/md5',"TestController@testMd5");
Route::get('/test/goods',"TestController@goods");
Route::get('/test/weather',"TestController@weather");
Route::get('/test/curl1',"TestController@curl1");
Route::get('/test/guzzle1',"TestController@guzzleTest1");


Route::get('/hello','TestController@hello');
Route::get('/sql1','TestController@sql1');
Route::get('/u','TestController@u');

//Redis
Route::get('/redis1','TestController@redis1');
Route::get('/redis2','TestController@redis2');


//商品
Route::get('/goods/detail','GoodsController@detail');       //商品详情
Route::get('/goods/list','GoodsController@goodsList');       //商品列表
Route::get('/goods/fav','GoodsController@fav');       //商品收藏

//用户
Route::get('/user/regist','UserController@regist');         //注册 前台
Route::post('/user/regist','UserController@registDo');         //注册 后台
Route::get('/user/login','UserController@login');         //登录 前台
Route::post('/user/login','UserController@loginDo');         //登录 后台
Route::get('/user/active','UserController@active');         //激活用户
Route::get('/user/center','UserController@center');         //个人中心

Route::get('/cart','CartController@index');               //购物车
Route::get('/cart/add','CartController@add');               //加入购物车


Route::get('/order/create','OrderController@add');          //生成订单

Route::get('/pay/ali','PayController@aliPay');                   //订单支付(支付宝)


Route::get('/github/callback','UserController@githubLogin');               //GITHUB登录


Route::get('/prize','PrizeController@index');           //抽奖
Route::get('/prize/start','PrizeController@add');           //开始抽奖

