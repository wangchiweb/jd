<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Prize;
use App\Model\Goods;

class IndexController extends Controller
{
    /**前台首页 */
    public function list(){
        // //offset (offset 从哪里开始取数据), limit (limit 想要查询的数据条数)
        // $res=Goods::offset(0)->limit(6)->get();
        // $res1=Goods::offset(6)->limit(6)->get();

        $res=Goods::limit(12)->get();
        // dd($res);
        return view('index/index/list',['res'=>$res]);
    }

    /**开始抽奖 */
    public function start(){
        $user_id=session()->get('user_id');
        // echo $user_id;die;
        if(empty($user_id)){   //如果用户未登录
            $response=[
                'errno'=>400003,
                'msg'=>'未登录'
            ];
            return $response;
        }

        //检查用户当天是否已有抽奖记录
        $time=strtotime(date("Y-m-d"));
        $res=Prize::where(['user_id'=>$user_id])->where('prize_time','>=',$time)->first();
        // dd($res);
        if($res){
            $response=[
                'errno'=>300008,
                'msg'=>'今天的抽奖次数为0'
            ];
            return $response;
        }
        $rand=mt_rand(1,10000);
        // echo $rand;die;
        // $rand=2;
        $level=0;
        if($rand>=1 && $rand<=10){
            // echo '一等奖';
            $level='1';
        }elseif($rand>=11 && $rand<=30){
            // echo '二等奖';
            $level='2';
        }elseif($rand>=31 && $rand<=60){
            // echo '三等奖';
            $level='3';
        }

        //记录抽奖信息
        $prize_data=[
            'user_id'=>$user_id,
            'level'=>$level,
            'prize_time'=>time()
        ];
        $prize_id=Prize::insertGetId($prize_data);
        // dd($prize_id);
        //是否纪录成功
        if($prize_id>0){
            $data=[
                'errno'=>0,
                'msg'=>'ok',
                'data'=>[
                    'level'=>$level
                ]
            ];
        }else{
            //异常
            $data=[
                'errno'=>500008,
                'msg'=>'数据异常，请重试',
            ];
        }
            

        return $data;
    }

    /**领券 */
    public function coupon(){
        
        $response=[
            'errno'=>0,
            'msg'=>'ok'
        ];
        return $response;
    }
}
