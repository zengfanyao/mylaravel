<?php
namespace Socket\Lib;
use \GatewayWorker\Lib\Gateway;

class Message{
    public static $guid;

	/**
	 * 获取数据,解释数据
	 * @author: 亮 <chenjialiang@han-zi.cn>
	 */
	public static function getData($msg){
		$data = json_decode($msg,true);

		if($data === false){
			return false;
		}

		if(!isset($data['guid']) || !isset($data['content']) || !isset($data['content']['type'])){
			return false;
		}

		self::$guid=$data['guid'];
		return $data['content'];
	}


	/**
	 * 格式化发送消息
	 * @param $msg string||array 内容
	 * @param $type string 类型
	 * @author: 亮 <chenjialiang@han-zi.cn>
	 * @return array
	 */
	public static function formatData($msg,$type,$error_id='ok'){
		$data = array(
			'guid' => Tools::createGuid(),
			'content' => array(
				'type' => $type,
				'msg' => $msg,
				'error_id' => $error_id,
			)
		);

		if($type == 'reply'){
			$data['content']['reply_guid']=self::$guid;   //返回发送过来的id
		}

		return json_encode($data);
	}

    /**
     * 格式化回复消息
     * @param $msg string||array 内容
     * @param $type string 类型
     * @author: 亮 <chenjialiang@han-zi.cn>
     * @return array
     */
    public static function formatReplyData($msg,$error_id='ok'){
		$data=self::formatData($msg,'reply',$error_id);
        return $data;
    }

    /**
     * 回复格式化消息
     * @param $msg string||array 内容
     * @param $error string 错误信息
     * @author 亮
     * @return array
     */
    public static function replyFormatData($msg,$type,$error_id='ok'){
        Gateway::sendToCurrentClient(self::formatData($msg,$type,$error_id));
    }

    /**
     * 回复消息
     * @param $msg string||array 内容
     * @param $error string 错误信息
     * @author 亮
     * @return array
     */
    public static function reply($msg,$error_id='ok'){
        Gateway::sendToCurrentClient(self::formatReplyData($msg,$error_id));
    }

	/**
     * 回复错误消息
     * @param $msg string||array 内容
     * @param $error string 错误信息
     * @author 亮
     * @return array
     */
    public static function replyError($msg,$error_id='error'){
		Message::replyFormatData($msg,'error',$error_id);
    }

	/**
	 * 发送到内部接口请求
	 * @param array $data 需要发送的数据
	 * @author: 亮 <chenjialiang@han-zi.cn>
	 */
	public static function sendToInterface($data,$url){
		//请求地址
		$url=Config::get('socket')['api_domain'].$url;
		//队列逻辑
		$param['pwd']=Config::get('socket')['socket_key'];
		$param=array_merge($param,$data);
		$send=Tools::httpPost($url,$param,false,1);
		$res=json_decode($send,true);
		if(Tools::$http_code!='200' || $res['status']==false){
			return false;
		}
		return $res;
	}
}