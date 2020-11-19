<?php

namespace App\Http\Controllers\Wx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Model\Goods;

class ApiController extends Controller
{
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
    public function login(){
        //接受code
        $code=request()->get('code');
        // print_r($code);
        //使用code
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=".env("WX_XCX_APPID")."&secret=".env("WX_XCX_APPSECRET")."&js_code=".$code."&grant_type=authorization_code";
        $data=json_decode(file_get_contents($url),true); 
        // print_r($data);
        //自定义登录状态
        if(isset($data['errcode'])){   //登录失败
            $response=[
                'errno'=>50001,
                'msg'=>'登录失败'
            ];
        }else{   //登录成功
            $token=sha1($data['openid'].$data['session_key'].mt_rand(0,999999));
            //保存token
            $token_key='xcx_token:'.$token;
            Redis::set($token_key,time());
            //设置过期时间
            Redis::expire($token_key,7200);
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
        $goods_id=$request->get('goods_id');
        //echo $goods_id;die;
        $key = 'detail:'.$goods_id;
        $detail = Redis::hGetall($key);
        // 查询缓存
        if(empty($detail)){
            $detail = Goods::find($goods_id);
            // 商品不存在
            if(empty($detail)){
                return redirect('goods/list');
            }
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
}
