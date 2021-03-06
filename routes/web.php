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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/test', function () {
    //echo date("Y-m-d H:i:s");
    echo phpinfo();
});

/*LoginController控制器(前台)*/
	//登录
	Route::prefix('login')->group(function(){   //路由分组
		Route::any('register','Index\LoginController@register');//注册视图
        Route::any('registerdo','Index\LoginController@registerdo');//执行注册
        Route::any('login','Index\LoginController@login');//登录视图
        Route::any('logindo','Index\LoginController@logindo');//执行登录
        Route::any('quit','Index\LoginController@quit');//退出登录
        Route::any('git','Index\LoginController@git');//退出登录
    });

/*IndexController控制器(前台)*/
	//首页
        Route::get('/','Index\IndexController@list');//首页视图 
        Route::get('/start','Index\IndexController@start');//开始抽奖
        Route::get('/coupon','Index\IndexController@coupon')->middleware('check.login');//领券

/**GoodsController控制器(前台) */
    //商品
    Route::prefix('goods')->group(function(){   //路由分组
        Route::any('list','Index\GoodsController@list');//商品列表
        Route::any('detail','Index\GoodsController@detail');//商品详情  
    });
    
/**TestController控制器 */
    //测试
    Route::prefix('test')->group(function(){   //路由分组
        Route::any('weather','TestController@weather');   //使用 file_get_contents获取当前城市的天气信息
        Route::any('curl','TestController@curl');   //使用 curl获取当前城市的天气信息
        Route::any('guzzle','TestController@guzzle');   //使用GuzzleHttp获取当前城市的天气信息
    });

/**CartController控制器(前台) */
    //购物车
    Route::prefix('cart')->group(function(){   //路由分组
        Route::any('list','Index\CartController@list');//购物车列表
        Route::any('add','Index\CartController@add');//加入购物车
    });

/**MovieController控制器 */
    //电影票
    Route::prefix('movie')->group(function(){   //路由分组
        Route::get('index','MovieController@index');   //电影票列表
    });


/**微信 */
Route::prefix('/wechat')->group(function(){   //路由分组
    Route::get('/','WeachatController@wechat'); //接口测试
    Route::post('/','WeachatController@event'); //接受事件推送
    Route::get('/getaccesstoken','WeachatController@getaccesstoken'); //获取access_token
    Route::post('/createmenu','WeachatController@createmenu'); //接受事件推送

});

/**小程序接口 */
Route::prefix('/api')->group(function(){   //路由分组
    Route::get('/test','Wx\ApiController@test');   //测试
    Route::post('/login','Wx\ApiController@login');   //登录
    Route::get('/list','Wx\ApiController@list');   //商品列表
    Route::get('/detail','Wx\ApiController@detail');   //商品详情
    Route::post('/addcart','Wx\ApiController@addcart')->middleware('check.token');   //加入购物车
    Route::get('/cartlist','Wx\ApiController@cartlist')->middleware('check.token');   //购物车列表
    Route::post('/Collection','Wx\ApiController@Collection')->middleware('check.token');   //收藏
    Route::post('/delcart','Wx\ApiController@delcart')->middleware('check.token');   //购物车中删除商品
});