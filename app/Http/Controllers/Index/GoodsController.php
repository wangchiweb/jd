<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Goods;
use Illuminate\Support\Facades\Redis;
class GoodsController extends Controller
{
    /**商品列表*/
    public function list(){
        $goodsinfo=Goods::limit(33)->get();
        //dd($goodsinfo);
        return view('index/goods/list',['goodsinfo'=>$goodsinfo]);
    }
    
    /**商品详情 */
    public function detail(Request $request){
        $goods_id=$request->get('goods_id');
        //echo $goods_id;die;
        $key = 'res:'.$goods_id;
        $res = Redis::hGetall($key);
        // 查询缓存
        if(empty($res)){
            $res = Goods::find($goods_id);
            // 商品不存在
            if(empty($res)){
                return redirect('index/goods/list');
            }
            Redis::incr('shop_view:'.$res['goods_id']);
            $res = $res->toArray();
            Redis::hMset($key,$res);
        }
        //dd($res);
        return view('index/goods/detail',['res'=>$res]);
    } 
}  
 