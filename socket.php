<?php
use Workerman\Worker;

require __DIR__.'/vendor/autoload.php';

ini_set('display_errors', 'on');
error_reporting(E_ALL);

// 检查扩展
if(!extension_loaded('pcntl'))
{
    exit("Please install pcntl extension. See http://doc3.workerman.net/install/install.html\n");
}

if(!extension_loaded('posix'))
{
    exit("Please install posix extension. See http://doc3.workerman.net/install/install.html\n");
}

// 标记是全局启动
define('GLOBAL_START', 1);
$root_path=__DIR__;
define('ROOT_PATH', $root_path);

//配置文件路径
$env_obj = new \Dotenv\Dotenv(ROOT_PATH,'.env');
$env_obj->load();


// 加载所有Applications/*/start.php，以便启动所有服务
foreach(glob(__DIR__.'/app/socket/start*.php') as $start_file)
{
    require_once $start_file;
}
// 运行所有服务
Worker::runAll();