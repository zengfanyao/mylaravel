<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use Closure;


/**
 * 后台管理权限中间件
 * Class AdminCheck
 * @package App\Http\Middleware
 */
class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $roles = \Jwt::get('admin_info.role');

        $permissions = array();

        //超级管理员角色,则通过
        if(in_array(1,$roles)){
            return $next($request);
        }

        //获取角色对应的权限
        foreach ($roles as $v) {

            $role = \App\Model\AdminRoleModel::where('id', $v)->where('is_on', 1)->first();
            if (!$role) {
                continue;
            }

            $get_cache = \Cache::get('cache:role_permission:'.$v);

            if(empty($get_cache)){
                $permission = $role->permissions()->get(['name', 'code']);

                if (!$permission->isEmpty()) {
                    $temp = array();
                    foreach ($permission as $vv) {
                        $temp_key=explode('@',$vv->code);
                        $key = $temp_key[0].'Controller@'.$temp_key[1];
                        $temp[$key] = 1;
                    }

                    $get_permission = $temp;
                    \Cache::add('cache:role_permission:'.$v,$get_permission,60*60);
                }
                else{
                    continue;
                }
            }
            else{
                $get_permission = $get_cache;
            }

            $permissions = array_merge($permissions, $get_permission);
        }

        $route_info =\Route::getCurrentRoute();

        $current_key=str_replace($route_info->action['namespace'].'\Admin\\','',$route_info->action['controller']);

        if(isset($permissions[$current_key]) && $permissions[$current_key] == 1){
            return $next($request);
        }

        throw new ApiException('你没有访问权限,请联系管理员!','PERMISSION_DENIED',403);
    }


}
