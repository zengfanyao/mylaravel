<?php
namespace App\Logic;

class TokenLogic{

    /**
     * 获取token
     * @param $user_id
     * @return string
     */
    public static function getToken($user_id){
        $token = md5(uniqid(rand(), TRUE));
        $value = array(
            'customer_id' => $user_id
        );
        \Cache::put($token, $value, 1);
        return $token;
    }

    /**
     * 检验token
     * @param $token
     * @return mixed
     */
    public static function checkToken($token){
        $res=\Cache::get($token);
        return $res;
    }

}