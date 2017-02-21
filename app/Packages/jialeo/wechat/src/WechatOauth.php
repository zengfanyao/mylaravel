<?php

namespace JiaLeo\Wechat;

use App\Exceptions\ApiException;

/**
 * 微信授权
 */
class WechatOauth
{

    public $weObj;  //微信实例
    private $access_token;  //code获取的access_token

    /**
     * 注释说明
     * @param $params
     * @author: 亮 <chenjialiang@han-zi.cn>
     */
    public function __construct($params)
    {
        //实例化微信类
        $weObj = new Wechat($params['type']);
        $this->weObj = $weObj;
        $this->params = $params;

        $query['callback'] = $_GET['callback'];
        $query['type'] = $params['type'];
        $query['token'] = $params['token'];
        $this->callback = url()->current() . '?' . http_build_query($query);
    }

    /**
     * 运行
     * @return array|bool|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws ApiException
     */
    public function run()
    {
        if (empty($_GET['code']) && empty($_GET['state'])) {    //第一步
            return $this->firstStep();
        } elseif (!empty($_GET['code']) && $_GET['state'] == 'snsapi_base') { //静默请求获得openid
            return $this->afterSilentOauth();
        } elseif (!empty($_GET['code']) && $_GET['state'] == 'snsapi_userinfo') {   //弹出授权获取用户消息
            return $this->afterClickOauth();
        } else {
            return false;
        }
    }

    /**
     * 授权登录第一步
     * @author: 亮 <chenjialiang@han-zi.cn>
     */
    public function firstStep()
    {
        $reurl = $this->weObj->getOauthRedirect($this->callback, "snsapi_base", "snsapi_base");
        return redirect($reurl);
    }

    /**
     * 静默获取授权后逻辑
     * @author: 亮 <chenjialiang@han-zi.cn>
     * @return array  用户给的回调函数返回true,则返回该用户openid,反之则跳转用户点击授权
     */
    public function afterSilentOauth()
    {
        $accessToken = $this->weObj->getOauthAccessToken();
        if (!$accessToken || empty($accessToken['openid'])) {
            throw new ApiException('code错误', 'CODE_ERROR');
        }

        $this->access_token = $accessToken;

        //使用unionid作为用户标识
        if ($this->params['check_for'] === 'unionid') {
            $get_unionid = $this->weObj->getUserInfo($this->access_token['openid']);
            if (!isset($get_unionid['unionid'])) {
                throw new ApiException('获取unionid失败!', 'UNIONID_ERROR');
            }

            $this->access_token['unionid'] = $get_unionid['unionid'];
        }

        //是否存在用户
        $user_info = $this->checkUser();

        if (!$user_info && $this->params['is_oauth_user_info'] === true) {        //不存在用户 且 设置为通过显性授权获取用户信息
            $reurl = $this->weObj->getOauthRedirect($this->callback, "snsapi_userinfo", "snsapi_userinfo");
            return redirect($reurl);
        } elseif ($user_info) {       //存在用户
            $result = call_user_func_array($this->params['oauth_get_user_silent_function'], array($user_info));

            if ($result) {
                return redirect(urldecode($_GET['callback']));
            }
        } else {
            throw new ApiException('授权失败', 'AUTH_ERROR');
        }

        return false;
    }

    /**
     * 用户点击授权后逻辑
     * @author: 亮 <chenjialiang@han-zi.cn>
     */
    public function afterClickOauth()
    {
        $accessToken = $this->weObj->getOauthAccessToken();
        if (!$accessToken || empty($accessToken['openid'])) {
            throw new ApiException('code错误', 'CODE_ERROR');
        }

        $this->access_token = $accessToken;

        //拉取用户信息
        $user_info = $this->weObj->getOauthUserinfo($accessToken['access_token'], $accessToken['openid']);
        if(!$user_info){
            throw new ApiException('获取用户信息失败!', 'GET_USERINFO_ERROR');
        }

        if(isset($user_info['unionid'])){
            $this->access_token['unionid'] = $user_info['unionid'];
        }

        //检查是否存在用户
        $is_user = $this->checkUser();
        if (!$is_user) {
            //创健新用户
            $add_user = call_user_func_array($this->params['create_user_function'], array($user_info));
            $user_id = $add_user;
        } else {
            $user_id = $is_user['user_id'];
        }

        $result = call_user_func_array($this->params['oauth_get_user_info_function'], array($user_id, $user_info));

        if ($result) {
            return redirect(urldecode($_GET['callback']));
        }

        throw new ApiException('授权失败', 'AUTH_ERROR');
    }

    /**
     * 检查是否存在用户
     * @author: 亮 <chenjialiang@han-zi.cn>
     */
    public function checkUser()
    {
        if (empty($this->access_token) || empty($this->access_token['openid'])) {
            throw new ApiException('获取openid错误!', 'ACCESS_TOKEN_ERROR');
        }

        $openid = '';
        $unionid = '';

        //使用unionid作为用户标识
        if ($this->params['check_for'] === 'unionid') {
            if(empty($this->access_token['unionid'])){
                throw new ApiException('获取unionid错误!', 'UNIONID_ERROR');
            }

            $unionid = $this->access_token['unionid'];

            $where = array(
                'id2' => $unionid,
                'oauth_type' => 1
            );
        } else {
            $openid = $this->access_token['openid'];

            $where = array(
                'id1' => $openid,
                'oauth_type' => 1
            );
        }

        $is_user = \App\Model\UserAuthOauthModel::where($where)->first(['user_id']);
        if (!$is_user) {
            return false;
        }

        //返回的用户信息
        $user_info = array(
            'openid' => $openid,
            'unionid' => $unionid,
            'user_id' => $is_user->user_id
        );

        //保存更新信息
        set_save_data($is_user, [
            'access_token' => $this->access_token['access_token'],
            'expires_time' => time() + $this->access_token['expires_in'],
            'info' => json_encode($this->access_token)
        ]);
        $is_user->save();

        return $user_info;
    }
}
