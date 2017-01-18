<?php
namespace App\Logic\Admin;

use App\Exceptions\ApiException;

class LoginLogic{

    /**
     * 后台管理员登录
     * @param  string  $account  管理员帐号
     * @param  string  $password  登陆密码
     * @return   
     */
    public static function login($account, $password){
    	$admin=\DB::table('admin')->where('account',$account)->first(['id','account','password','salt','name']);

        if(!$admin){
        	throw new ApiException("用户不存在!");
        }

        load_helper('Password');
        $get_password=encrypt_password($password,$admin->salt);

        if($admin->password != $get_password){
            throw new ApiException("密码错误!");
        }

        \Jwt::set('admin_info',['admin_id'=>$admin->id]);
        return $admin->name;
    }

}
