<?php

namespace App\Http\Middleware;

use Closure;


class JwtAuth
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

        if(! \Jwt::run($request,'')){
            return response()->json([
                'status'=>false,
                'error_msg'=>'AUTHORIZATION验证失败',
                'error_code'=>'AUTHORIZATION_INVALID'
            ],401);
        }

        return $next($request);
    }


}
