<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class CheckToken
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
        //验证token
        $access_token = $request->get('access_token');
        // dd($access_token);
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
        return $next($request);
    }
}
