<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // echo "中间件";

        $user_id=session()->get('user_id');
        // echo $user_id;die;
        //判断是否是Ajax请求
        if(empty($user_id)){
            if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest'){
                $response = [
                    'errno' => 400003,
                    'msg'   => "请先登录"
                ];
                die(json_encode($response));
            }
            return redirect('login/login');
        }
        return $next($request);
    }
}
