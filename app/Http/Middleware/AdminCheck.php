<?php

namespace App\Http\Middleware;

use Closure;


class AdminCheck
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
        if (config('app.debug') === true && $request->query->get('usertest') && $request->query->get('usertest') > 0) {
            \Jwt::set('admin_info', array(
                'admin_id' => $request->query->get('usertest')
            ));
        }

        if(!(!empty(\Jwt::$sessionData['admin_info']) && !empty(\Jwt::$sessionData['admin_info']['admin_id']))){
            return response()->json([
                'status'=>false,
                'error_msg'=>'你还没有登录或登录已过期!',
                'error_code'=>'NO LOGIN'
            ],400);
        }

        return $next($request);
    }


}
