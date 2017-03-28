<?php
namespace Socket\Lib;
use Workerman\Worker;

class Log{

	/**
	 * 写日志
	 * @author: 亮 <chenjialiang@han-zi.cn>
	 * @param string $msg 日志内容
	 * @param string $path 日志文件夹名称 (路径为Log/$path)
	 */
	public static function write($msg,$path='error'){
		if (!Worker::$daemonize) {
			echo $msg;
		}
		else{
			$path=ROOT_PATH.'/Log/'.$path.'/'.date('Ymd').'.log';
			$isDir=Tools::isDirExists(dirname($path));

			if($isDir){
				$msg=PHP_EOL.'-----------------------'.PHP_EOL.date('Y-m-d H:i:s').PHP_EOL.$msg.PHP_EOL;
				file_put_contents($path, $msg, FILE_APPEND | LOCK_EX);
			}
		}
	}

}