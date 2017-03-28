<?php
namespace Socket\Lib;

class Tools{

	static $http_code = 200;   //httpPost function 的http状态码
	static $http_content ;

	/**
	 * POST 请求
	 * @param string $url
	 * @param array $param
	 * @param bool $post_file 是否传送文件,true的时候param为file类型(列如:$_FILE['file1'])
	 * @param int $tiemout 超时时间
	 * @return string content
	 */
	public static function httpPost($url, $param,$post_file=false,$tiemout=2) {
		self::$http_code=0;
		$oCurl = curl_init();
		if (stripos($url, "https://") !== FALSE) {
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
		}
		if (is_string($param) || $post_file) {
			$strPOST = $param;
		} else {
			$aPOST = array();
			foreach ($param as $key => $val) {
				$aPOST[] = $key . "=" . urlencode($val);
			}
			$strPOST = join("&", $aPOST);
		}
		curl_setopt($oCurl, CURLOPT_URL, $url);
		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($oCurl, CURLOPT_POST, true);
		curl_setopt($oCurl, CURLOPT_POSTFIELDS, $strPOST);
		curl_setopt($oCurl, CURLOPT_TIMEOUT,$tiemout);  //超时时间

		$header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
		$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
		$header[] = "Cache-Control: max-age=0";
		$header[] = "Connection: keep-alive";
		$header[] = "Keep-Alive: 300";
		$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
		$header[] = "Accept-Language: en-us,en;q=0.5";
		$header[] = "Pragma: "; // browsers keep this blank.

		curl_setopt($oCurl, CURLOPT_HTTPHEADER, $header);

		$sContent = curl_exec($oCurl);
		$aStatus = curl_getinfo($oCurl);

		self::$http_content=$sContent;

		curl_close($oCurl);
		self::$http_code=intval($aStatus["http_code"]);
		if (intval($aStatus["http_code"]) == 200) {
			return $sContent;
		} else {
			return false;
		}
	}

	/**
	 * 判断目录是否存在,不存在则创建目录
	 * @param string $path 目录
	 * @return bool
	 */
	public static function isDirExists($path) {
		$f = true;
		if (file_exists($path) == false) {//创建图片目录
			if (mkdir($path, 0777, true) == false)
				$f = false;
			else if (chmod($path, 0777) == false)
				$f = false;
		}

		return $f;
	}

	/**
	 * 生成guid
	 * */
	public static function createGuid() {
		$charid = strtoupper(md5(uniqid(mt_rand(), true)));
		$hyphen = chr(45); // "-"
		$uuid =  substr($charid, 0, 8) . $hyphen
			. substr($charid, 8, 4) . $hyphen
			. substr($charid, 12, 4) . $hyphen
			. substr($charid, 16, 4) . $hyphen
			. substr($charid, 20, 12);
		return $uuid;
	}
}