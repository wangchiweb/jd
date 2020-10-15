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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    echo date("Y-m-d H:i:s");
});

/*LoginController控制器(前台)*/
	//登录模块的增删改查
	Route::prefix('index/login/')->group(function(){   //路由分组
		Route::any('register','Index\LoginController@register');//注册视图
        Route::any('registerdo','Index\LoginController@registerdo');//执行注册
        Route::any('login','Index\LoginController@login');//登录视图
        Route::any('logindo','Index\LoginController@logindo');//执行登录
    });

/*IndexController控制器(前台)*/
	//首页模块的增删改查
	Route::prefix('index/index/')->group(function(){   //路由分组
		Route::any('list','Index\IndexController@list');//首页视图
    });

