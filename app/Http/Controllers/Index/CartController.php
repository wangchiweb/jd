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
                return redirect('login/login');
            }

        $goods_id = $request->get('goods_id');
        //echo $goods_id;die;
        $goods_num = $request->get('goods_num',1);
        // echo $goods_num;die;    

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
            return redirect('cart/list');
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
            return redirect('login/login');
        }

        //获取购物车商品信息
        $list=Cart::where(['user_id'=>$user_id])->get();
        // dd($list);
        $goods=[];
        foreach($list as $k=>$v){
            $goods[]=Goods::find($v['goods_id'])->toArray();
        }
        // dd($goods);


        // 检查是否下架 库存是否充足  ...
        $goods_number=[];
        foreach($goods as $k=>$v){
            $goods_number[]=$v['goods_number'];
        }
        // dd($goods_number);
        foreach($goods_number as $k=>$v){
            $goods_number=(int)$v;
            // dd($goods_number);
            if($goods_number<10){
                echo '库存紧张';  
            }
        }
        // die;
        echo "<br>";  
        $is_shelf=[];
        foreach($goods as $k=>$v){
            $is_shelf[]=$v['is_shelf'];
        }
        // dd($is_shelf);
        foreach($is_shelf as $k=>$v){
            $is_shelf=$v;
            // dd($is_shelf);
            if($is_shelf==1){
                echo '商品已下架';  
            }
        }
        
        return view('index/cart/list',['goods'=>$goods,'goods_number'=>$goods_number,'is_shelf'=>$is_shelf]);
    }
}
