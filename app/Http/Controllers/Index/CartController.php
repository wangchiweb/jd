<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Cart;
use App\Model\Goods;
use App\Model\Order;

class CartController extends Controller{

    /**加入购物车 */
    public function add(Request $request){
        $user_id = session()->get('user_id');
        //echo $user_id;die;
            if(empty($user_id)){
                return redirect('index/login/login');
            }

        $goods_id = $request->get('goods_id');
        //echo $goods_id;die;
        $goods_num = $request->get('goods_num',1);
        //echo $goods_num;die;    
        // 检查是否下架 库存是否充足  ...

        //购物车保存商品信息
        $cart_info=[
            'goods_id'=>$goods_id,
            'user_id'=>$user_id,
            'goods_num'=>$goods_num,
            'add_time'=>time(),
        ];

        $res=Cart::insertGetId($cart_info);
        //dd($res);
        if($res>0){
            return redirect('index/cart/list');
        }else{
            $data=[
                'errno'=>500001,
                'msg'=>'加入购物车失败'
            ];
            echo json_encode($data);
        }
    }

    /**购物车列表 */
    public function list(){
        $user_id = session()->get('user_id');
        //echo $user_id;die;
        if(empty($user_id)){
            return redirect('index/login/login');
        }

        //获取购物车商品信息
        $list=Cart::where(['user_id'=>$user_id])->get();
        //dd($list);
        $goods=[];
        foreach($list as $k=>$v){
            $goods[]=Goods::find($v['goods_id'])->toArray();
        }
        //dd($goods);
        return view('index/cart/list',['goods'=>$goods]);
    }
}
