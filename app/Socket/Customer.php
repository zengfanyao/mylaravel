<?php
use \GatewayWorker\Lib\Gateway;
use JiaLeo\Laravel\Socket\Lib\Message;

class Customer{

    /**
     * 客户登录
     * @author 伟健
     * @param string $client_id
     * @param array $data 登录信息
     */
    public static function login($client_id,$data){

        if(!empty(Gateway::getSession($client_id))){ //未登录或登录过期
            Message::replyError('登录已过期');
            return false;
        }
        if($data['type']!='customer_login'){
            Message::replyError('登录错误');
            return false;
        }

        if(!isset($data['token'])){
            Message::replyError('token不能为空');
            return false;
        }

        //请求地址
        $res=Message::sendToInterface(['token' => $data['token']],'/api/socket/check_token');
        if(!$res){
            Message::replyError('用户登录失败');
            return false;
        }

        $session=array(
            'customer_id'=>$res['data']['customer_id']
        );
        Gateway::bindUid($client_id,'customer_'.$session['customer_id']); //绑定uid
        Gateway::setSession($client_id,$session);
        Message::replyError('客户登录成功','login_success');
        return true;
    }

    /**
     * 客户登录
     * @author 伟健
     * @param string $client_id
     * @param array $data 聊天消息
     */
    public static function chat($client_id,$data){
        $session=Gateway::getSession($client_id); //获取session信息
        if(empty($session)){
            Message::replyError('用户登录已过期','reply_send_msg');
            return false;
        }

        if(empty($data['msg'])){
            Message::replyError('消息不能为空','reply_send_msg');
            return false;
        }

        if(empty($data['msg']['content'])){
            Message::replyError('消息不能为空','reply_send_msg');
            return false;
        }

        //发送聊天记录

        $save = array(
            'content' => $data['msg']['content'], //消息内容
            'type' => !empty($data['msg']['msg_type'])?$data['msg']['msg_type']:1, //消息类型
            'from_customer_id' => $session['customer_id'], //客户customer_id
            'to_customer_id' => $data['msg']['customer_id'], //发送客户customer_id
            'add_time' => time()
        );

        if(Gateway::isUidOnline('customer_'.$data['msg']['customer_id'])){ //在线
            $message=Message::formatData($save, 'new_message');
            Gateway::sendToUid('customer_'.$data['msg']['customer_id'],$message);
        }

        Message::reply('发送成功','reply_send_msg');

        return true;
    }
}