<?php 
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
use \Workerman\Worker;
use \GatewayWorker\Gateway;
use JiaLeo\Laravel\Socket\Lib\Config;

$config = Config::get('socket');

$gateway = new Gateway("websocket://".$config['gateway_address']);
// gateway名称，status方便查看
$gateway->name = 'AppGateway';
// gateway进程数
$gateway->count = $config['gateway_count'];
// 本机ip，分布式部署时使用内网ip
$gateway->lanIp = $config['gateway_lan_ip'];
// 内部通讯起始端口，假如$gateway->count=4，起始端口为4000
// 则一般会使用4000 4001 4002 4003 4个端口作为内部通讯端口 
$gateway->startPort = $config['gateway_start_port'];
// 服务注册地址
$gateway->registerAddress = $config['get_register_address'];

// 心跳间隔
//$gateway->pingInterval = 10;
// 心跳数据
//$gateway->pingData = '{"type":"ping"}';

/* 
// 当客户端连接上来时，设置连接的onWebSocketConnect，即在websocket握手时的回调
$gateway->onConnect = function($connection)
{
    $connection->onWebSocketConnect = function($connection , $http_header)
    {
        // 可以在这里判断连接来源是否合法，不合法就关掉连接
        // $_SERVER['HTTP_ORIGIN']标识来自哪个站点的页面发起的websocket链接
        if($_SERVER['HTTP_ORIGIN'] != 'http://kedou.workerman.net')
        {
            $connection->close();
        }
        // onWebSocketConnect 里面$_GET $_SERVER是可用的
        // var_dump($_GET, $_SERVER);
    };
}; 
*/

//设置路由
$gateway->router = function($worker_connections, $client_connection, $cmd, $buffer)
{

    //排除内部接口worker
    /*unset($worker_connections['127.0.0.1:Internal Interface:0']);
    unset($worker_connections['127.0.0.1:Player Queue:0']);
    unset($worker_connections['127.0.0.1:Player Queue:1']);
    unset($worker_connections['127.0.0.1:Player Queue:2']);
    unset($worker_connections['127.0.0.1:Player Queue:3']);
    unset($worker_connections['127.0.0.1:Player Queue:4']);*/

    //随机路由
    return $worker_connections[array_rand($worker_connections)];
};

// 如果不是在根目录启动，则运行runAll方法
if(!defined('GLOBAL_START')) {
    Worker::runAll();
}

