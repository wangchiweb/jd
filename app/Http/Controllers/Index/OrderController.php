<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Order;
use App\Model\OrderGoods;
class OrderController extends Controller
{
    //生成订单
    public function add(){
        //TODO 获取购物车中的商品（根据当前用户id）

        //TODO 生成订单号 计算订单总价  记录订单信息（订单表orders）

        // TODO 记录订单商品  （订单商品表orders_goods）

        //TODO 清空购物车

        //TODO 跳转至 支付页面
        echo "生成订单成功,正在跳转支付页面";

    }









    /**订单支付(支付宝) */
    public function alipay(Request $request){
        $order_id = $request->get('order_id');
        echo "订单ID: ". $order_id;

        //根据订单号，查询订单信息，验证订单是否有效（未支付、未删除、未过期）



        //组合参数，调用支付接口，支付

        // 1 请求参数
        $param2 = [
            'out_trade_no'      => $order_id,     //商户订单号
            'product_code'      => 'FAST_INSTANT_TRADE_PAY',
            'total_amount'      => 0.01,    //订单总金额
            'subject'           => '2004-测试订单-'.Str::random(16),
        ];  

        // 2 公共参数
        $param1=[ 
            'app_id'=>env('ALIPAY_APP_ID'),
            'method'=>'alipay.trade.page.pay',
            'return_url'=>'',   //同步通知地址，真实服务器URL
            'charset'=>'utf-8',
            'sign_type'=>'RSA2',
            'timestamp'=>date('Y-m-d H:i:s'),
            'version'=>'1.0',
            'notify_url'=>'',   //异步通知，真实服务器URL
            'biz_content'=>json_encode($param2),
        ];



        // 计算签名
        ksort($param1);

        $str = "";
        foreach($param1 as $k=>$v)
        {
            $str .= $k . '=' . $v . '&';
        }
        $str = rtrim($str,'&');     // 拼接待签名的字符串
        $sign = $this->aliSign($str);

        //沙箱测试地址
        $url = 'https://openapi.alipaydev.com/gateway.do?'.$str.'&sign='.urlencode($sign);
        return redirect($url);
    }
}
