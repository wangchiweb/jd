<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
class LoginController extends Controller{
    /**注册视图 */
    public function register(){
        return view('index/login/register');
    }

    /**执行注册 */
    public function registerdo(Request $request){
	    $validatedData = $request->validate(
	    	[
             'user_name' => 'required|unique:user', 
             'user_email' => 'required|unique:user',
             'user_tel' => 'required|unique:user',
             'user_pwd' => 'required', 
             'confirm_pwd' => 'required|same:user_pwd', 
	    	],
	    	[
	    	 'user_name.required'=>'用户名不能为空',
             'user_name.unique'=>'用户名已存在',
             'user_email.required'=>'邮箱不能为空',
             'user_email.unique'=>'邮箱已存在',
             'user_tel.required'=>'手机号不能为空',
	    	 'user_tel.unique'=>'手机号已存在',
             'user_pwd.required'=>'密码不能为空',
             'confirm_pwd.required'=>'确认密码不能为空',
             'confirm_pwd.same'=>'两次输入的密码不一致',
	    	]
	    );
        $data=$request->except('_token');
        $data['register_time']=time();
        $data['last_login_ip']=$_SERVER['REMOTE_ADDR'];
        //生成密码
        $data['user_pwd']=password_hash($data['user_pwd'],PASSWORD_BCRYPT);
        $data['confirm_pwd']=password_hash($data['confirm_pwd'],PASSWORD_BCRYPT);
        //dd($data);
        $res=User::insert($data);
        //dd($res);
        if($res){
            return redirect('index/login/login');
        }
    }

    /**登录视图 */
    public function login(){
        return view('index/login/login');
    }

    /**执行登录 */
    public function logindo(Request $request){
        $user_name=$request->input('user_name');
        $user_pwd=$request->input('user_pwd');
        //dd($user_pwd);

        $key='login_count'.$user_name;
        //dd($key);
        //监测用户是否已经被锁定
        $count=Redis::get($key);
        if($count>5){
            Redis::expire($key,3600);
            echo "输入密码错误次数太多，用户已被锁定1小时，请稍后再试";die;
        }

        $res=User::where(['user_name'=>$user_name])
            ->orwhere(['user_email'=>$user_name])
            ->orwhere(['user_tel'=>$user_name])
            ->first();
        $res=$res->toArray();
        //dd($res);
        if(empty($res)){
            die('用户不存在');
        }
        //验证密码
        $p=password_verify($user_pwd,$res['user_pwd']);
        //dd($p);
        if(!$p){   //如果密码不正确
            //记录错误次数
            $count=Redis::incr('$key');
            Redis::expire($key,600);   //10分钟
            echo '密码错误次数:'.$count;die;
        }
        if($res){   //登录成功
            Redis::del($key);
            // 用户登录成功后设置session 存入用户的信息
            session(['user_id'=>$res['user_id'],'user_name'=>$res['user_name'],'user_tel'=>$res['user_tel'],'user_email'=>$res['user_email']]);
            // return redirect('');
        }
    }
}
