<?php

namespace App\Http\Controllers\Wx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Model\Goods;
use App\Model\Cart;
use App\Model\WxUser;

class ApiController extends Controller{
    /**测试 */
    public function test(){
        // echo 1234;die;
        // echo '<pre>';print_r($_GET);echo '<pre>';
        // echo '<pre>';print_r($_POST);echo '<pre>';

        $goodsinfo=[
            'goods_id'=>12343,
            'goods_name'=>"IPHONE",
            'price'=>99.980,
        ];
        echo json_encode($goodsinfo);
    }
    /**登录 */
    public function login(Request $request){
        //接受code
        $code=request()->get('code');
        // print_r($code);die;
        //获取用户信息
        $userinfo=json_decode(file_get_contents("php://input"),true);
        // dd($userinfo);

        //使用code
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=".env("WX_XCX_APPID")."&secret=".env("WX_XCX_APPSECRET")."&js_code=".$code."&grant_type=authorization_code";
        $data=json_decode(file_get_contents($url),true); 
        // dd($data);
        //自定义登录状态
        if(isset($data['errcode'])){   //登录失败
            $response=[
                'errno'=>50001,
                'msg'=>'登录失败'
            ];
        }else{   //登录成功
            $openid=$data['openid'];   //用户openID
            // dd($openid);
            //判断新用户 老用户
            $u=WxUser::where(['openid'=>$openid])->first();
            if($u){
                //老用户
            }else{
                $u_info=[
                    'openid'=>$openid,
                    'nickname'=>$userinfo['u']['nickName'],
                    'sex'=>$userinfo['u']['gender'],
                    'language'=>$userinfo['u']['language'],
                    'city'=>$userinfo['u']['city'],
                    'province'=>$userinfo['u']['province'],
                    'country'=>$userinfo['u']['country'],
                    'headimgurl'=>$userinfo['u']['avatarUrl'],
                    'subscribe_time'=>time(),
                    'type'=>3
                ];
                WxUser::insertGetId($u_info);
            }
            //获取user_id
            $user_id=$u['wx_user_id'];
            //生成token
            $token=sha1($data['openid'].$data['session_key'].mt_rand(0,999999));
            //保存token
            $redis_login_hash = 'h:xcx:login:' . $token;

            // dd($user_id);
            $login_info = [
                'user_id' => $user_id,
                'user_name' => "",
                'login_time' => date('Y-m-d H:i:s'),
                'login_ip' => $request->getClientIp(),
                'token' => $token,
                'openid'    => $openid
            ];
            // dd($login_info);
            //保存登录信息
            Redis::hMset($redis_login_hash, $login_info);
            // 设置过期时间
            Redis::expire($redis_login_hash, 7200);

            $response=[
                'errno'=>0,
                'msg'=>'登录成功',
                'data'=>[
                    'token'=>$token
                ]
            ];
        }
        return $response;
        
    }
    /**商品列表 */
    public function list(Request $request){
        // dd(235464563);
        // $list=Goods::select('goods_id','goods_name','shop_price','goods_img')->limit(10)->get()->toArray();
        // dd($list);
        $page_size=$request->get('ps');
        // dd($page_size);
        $list=Goods::select('goods_id','goods_name','shop_price','goods_img')->paginate($page_size)->toArray();
        // dd($list['data']);
        // dd($list->items());
        $response=[
            'errno'=>0,
            'msg'=>'ok',
            'data'=>[
                'list'=>$list['data']
            ]
        ];
        return $response;
    }
    /**商品详情 */
    public function detail(Request $request){
        //获取token
        $access_token = $request->get('access_token');
        // dd($access_token);
        //验证token是否有效
        $redis_login_hash = 'h:xcx:login:' . $access_token;
        $login_info = Redis::hgetAll($redis_login_hash);
        // dd($login_info);
        if($login_info){
            $_SERVER['user_id'] = $login_info['user_id'];
        }else{
            $response = [
                'errno' => 400003,
                'msg'   => "未授权"
            ];
            die(json_encode($response));
        }

        $goods_id=$request->get('goods_id');
        //echo $goods_id;die;
        $key = 'detail:'.$goods_id;
        $detail = Redis::hGetall($key);
        // 查询缓存
        if(empty($detail)){
            $detail = Goods::find($goods_id);

            Redis::incr('shop_view:'.$detail['goods_id']);
            $detail = $detail->toArray();
            Redis::hMset($key,$detail);
        }
        // dd($detail);
        $response=[
            'errno'=>0,
            'msg'=>'ok',
            'data'=>[
                'detail'=>$detail
            ]
        ];
        return $response;
    }
    /**加入购物车 */
    public function addcart(Request $request){
        $user_id=$_SERVER['user_id'];
        // echo $user_id;die;
        $goods_num=$request->post('goods_num',1);
        // dd($goods_num);
        $goods_id=$request->post('goods_id');
        // echo $goods_id;die; 

        //查询商品的价格
        $price=Goods::find($goods_id)->shop_price;

        //查询购物车中的商品是否存在
        $cartinfo=Cart::where(['user_id'=>$user_id,'goods_id'=>$goods_id])->first();
        // dd($cartinfo);
        if($cartinfo){   //商品数量 +1
            Cart::where(['goods_id'=>$goods_id])->update(['goods_num'=>$goods_num]);
            $response = [
                'errno' => 0,
                'msg'   => 'ok'
            ];
        }else{
            //购物车保存商品信息
            $cart_info=[
                'goods_id'=>$goods_id,
                'user_id'=>$user_id,
                'goods_num'=>1,
                'add_time'=>time(),
                'cart_price'=>$price
            ];

            $cart_id=Cart::insertGetId($cart_info);
            // dd($cart_id);
            if($cart_id){
                $response = [
                    'errno' => 0,
                    'msg'   => 'ok'
                ];
            }else{
                $response=[
                    'errno'=>500002,
                    'msg'=>'加入购物车失败'
                ]; 
            }
        }

        
        return $response;
    }
    /**购物车列表 */
    public function cartlist(){
        $user_id=$_SERVER['user_id'];
        // dd($user_id);
        $goods=Cart::where('user_id',$user_id)->get();
        // dd($goods);
        if(empty($goods)){   //购物车无商品 
            $response=[
                'errno'=>5000000,
                'msg'=>'失败',
            ];
        }
        //购物车有商品
        foreach($goods as $k=>&$v){
            $g=Goods::find($v['goods_id']);
            $v['goods_name']=$g->goods_name;
            $v['goods_img']=$g->goods_img;
        }
        // dd($goods);
        $response = [
            'errno' => 0,
            'msg'   => 'ok',
            'data'  => [
                'cartlist'  => $goods
            ]
        ];

        return $response;
    }
    /**收藏 */
    public function Collection(Request $request){
        $goods_id=$request->post('goods_id');
        // dd($goods_id);
        $user_id=$_SERVER['user_id'];
        // dd($user_id);
        //用户收藏的商品有序集合  ss有序集合的意思
        $redis_key='ss:goods:fav:'.$user_id;
            //将商品id加入有序集合，并给排序值
        Redis::Zadd($redis_key,time(),$goods_id);
        $response=[
            'errno'=>0,
            'msg'=>'ok'
        ];
        return $response;
    }
    /**购物车中删除商品 */
    public function delcart(Request $request){
        //接受goods_id(字符串)
        $goods_id=$request->post('goods_id');
        $goods_id=explode(',',$goods_id);   //把字符串转换为数组
        // dd($goods_id);
        $user_id=$_SERVER['user_id'];
        // dd($user_id);
        $res=Cart::where(['user_id'=>$user_id])->whereIn('goods_id',$goods_id)->delete();
        if($res){   //删除成功
            $response=[
                'errno'=>0,
                'msg'=>'ok'
            ];
        }else{
            $response=[
                'errno'=>500002,
                'msg'=>'内部错误'
            ];
        }
        return $response;
    }
}
