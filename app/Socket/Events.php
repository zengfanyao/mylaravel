<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license inreplyErrorion, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);
use \GatewayWorker\Lib\Gateway;
use JiaLeo\Laravel\Socket\Lib\Message;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{
    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     *
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id)
    {
        var_dump($client_id . '连接了');
    }

    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param mixed $message 具体消息
     */
    public static function onMessage($client_id, $message)
    {
        var_dump($client_id ,$message);

        $data = Message::getData($message);var_dump($data);
        if ($data === false) {
            Message::replyError('数据格式失败');
            return false;
        }

        //不用登录的type
        $nologin_array = array('init', 'customer_login', 'service_login', 'close', 'ping','chat');
        if (!in_array($data['type'], $nologin_array)) {
            $session = Gateway::getSession($client_id); //获取session信息
            if(empty($session)){
                Message::replyError('你还没有登录');
                return false;
            }
        }

        switch ($data['type']) {
            case 'init':   //初始化
                Message::replyError('初始化成功','reply_init');
                break;
            case 'customer_login':  //客户登录
                Customer::login($client_id, $data);
                break;
            case 'chat':
                Customer::chat($client_id, $data);
                break;
            case 'close':
                Message::replyError('用户尚未登录','no_login');
                break;
            default:
                Message::replyError('用户请求失败','request_fail');
        }

        Gateway::sendToCurrentClient('已收到你的信息!');

    }

    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id)
    {

        var_dump($client_id.'退出了!');

    }


}
