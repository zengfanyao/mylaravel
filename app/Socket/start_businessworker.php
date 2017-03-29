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
use \GatewayWorker\BusinessWorker;
use JiaLeo\Laravel\Socket\Lib\Config;

//获取配置
$config = Config::get('socket');


// bussinessWorker 进程
$worker = new BusinessWorker();

// worker名称
$worker->name = 'BusinessWorker';
// bussinessWorker进程数量
$worker->count = $config['worker_num'];
// 服务注册地址
$worker->registerAddress = $config['get_register_address'];

$worker->onWorkerStart = function () {

};

//$url = env('DEV_CONFIG_URL');


//var_dump(env('REDIS_PASSWORD'));


// 如果不是在根目录启动，则运行runAll方法
if (!defined('GLOBAL_START')) {
    Worker::runAll();
}

