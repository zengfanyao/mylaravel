<?php
namespace JiaLeo\Jwt;

use \Illuminate\Http\Request;
use \Firebase\JWT\JWT;


/**
 * jwtAuth类
 * Class JwtAuth
 * @author : 亮
 * @package App\Logic
 */
class JwtAuth
{
    //private static $key = "1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2l";
    private static $expires = 60; //设置过期时间(分钟)
    private static $seesionKey = '';  //会话key

    public static $encodeData = array();
    public static $sessionData = array();

    /**
     * 开始
     * @param string $token
     * @param Request $request
     * @return bool
     */
    public static function run(Request $request, $token = '')
    {
        if (empty($token)) {
            //获取header内容
            $auth_header = $request->header('Authorization');

            if (empty($auth_header)) {
                //获取url参数
                $auth_url = $request->query->get('token');
                if (empty($auth_url)) {
                    return false;
                } else {
                    $token = $auth_url;
                }
            } else {
                $token = $auth_header;
            }
        }

        return self::check($token);
    }

    /**
     * 验证jwt
     * @param Request $request
     * @return bool
     */
    public static function check($token)
    {

        try {
            self::$encodeData = (array)JWT::decode($token, config('app.key'), array('HS256'));
        } catch (\Exception $e) {
            return false;
        }

        self::$seesionKey = self::$encodeData['session_key'];

        $data = \Cache::get('session:' . self::$encodeData['session_key']);
        if (empty($data)) {
            return false;
        }

        //验证过期时间
        if ($data['expires_time'] < time()) {
            return false;
        }

        $time = time();
        $data['expires_time'] = $time + (self::$expires * 60);
        $data['refresh_time'] = $time;

        \Cache::put('session:' . self::$encodeData['session_key'], $data, self::$expires);
        self::$sessionData = $data;

        return true;
    }

    /**
     * 生成token
     * @param array $session_data
     * @return string
     */
    public static function createToken(array $session_data = array())
    {
        require_once app_path() . '/Helper/Password.php';
        $session_key = create_guid();

        $time = time();
        $session_data['create_at'] = $time;      //创建时间
        $session_data['expires_time'] = $time + (self::$expires * 60);  //过期时间

        $data = array(
            'session_key' => $session_key
        );

        \Cache::add('session:' . $session_key, $session_data, self::$expires);
        return JWT::encode($data, config('app.key'));
    }

    /**
     * 设置数据
     * @param $key
     * @param $value
     * @return bool
     */
    public static function set($key, $value)
    {
        //获取最新数据
        $data = \Cache::get('session:' . self::$encodeData['session_key']);
        if (empty($data)) {
            return false;
        }

        $data[$key] = $value;
        $time = time();
        $data['expires_time'] = $time + (self::$expires * 60);
        $data['refresh_time'] = $time;

        \Cache::put('session:' . self::$encodeData['session_key'], $data, self::$expires);
        return true;
    }

    /**
     * 获取数据
     * @param $key
     * @return array | bool
     */
    public static function get($key = '')
    {
        $data = self::$sessionData;
        if (empty($data)) {
            return false;
        }

        if (!empty($key)) {
            if (array_key_exists($key, $data)) {
                return $data[$key];
            }
            return false;
        }

        return $data;
    }

    /**
     * 删除数据
     * @param $key
     * @return array | bool
     */
    public static function delete($key = '')
    {
        //获取最新数据
        $data = \Cache::get('session:' . self::$encodeData['session_key']);
        if (empty($data)) {
            return false;
        }

        if (!empty($key)) {
            if (!array_key_exists($key, $data)) {
                return false;
            }
            unset($data[$key]);
            $time = time();
            $data['expires_time'] = $time + (self::$expires * 60);
            $data['refresh_time'] = $time;

            \Cache::put('session:' . self::$encodeData['session_key'], $data, self::$expires);
        } else {
            \Cache::forget('session:' . self::$seesionKey);
        }

        return true;
    }


    /**
     *  销毁
     */
    public static function destroy()
    {
        \Cache::forget('session:' . self::$encodeData['session_key']);
    }

    //TODO 数据签名验证

}