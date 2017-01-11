<?php

namespace App\Http\Middleware;

use Closure;


/**
 * websocket验证中间件
 * Class WsAuth
 * @package App\Http\Middleware
 */
class WsAuth
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
        if(empty($request->request->get('token'))){
            return response()->json([
                'status'=>false,
                'error_msg'=>'AUTHORIZATION验证失败',
                'error_code'=>'AUTHORIZATION_INVALID'
            ],401);
        }

        if(! \Jwt::run($request,$request->request->get('token'))){
            return response()->json([
                'status'=>false,
                'error_msg'=>'AUTHORIZATION验证失败',
                'error_code'=>'AUTHORIZATION_INVALID'
            ],401);
        }

        return $next($request);
    }


}
