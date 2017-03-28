<?php
namespace Socket\Lib;

class Config{

	static $config = array();

	public static function get($config_name){
		if(!array_key_exists($config_name,self::$config)){
			//尝试读取配置文件
			$path=ROOT_PATH.'/../config/'.$config_name.'.php';
			if(is_file($path)){
				self::$config[$config_name]=require_once $path;
			}
		}

		return self::$config[$config_name];
	}


}