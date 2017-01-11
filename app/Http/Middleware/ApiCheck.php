<?php

namespace App\Http\Middleware;

use Closure;


class ApiCheck
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

        if(!(!empty(\Jwt::$sessionData['user_info']) && !empty(\Jwt::$sessionData['user_info']['user_id']))){
            return response()->json([
                'status'=>false,
                'error_msg'=>'你还没有登录或登录已过期!',
                'error_code'=>'NO LOGIN'
            ],400);
        }

        return $next($request);
    }


}
