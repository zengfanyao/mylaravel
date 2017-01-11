<?php
return array(

	/* OSS云盘 */
	'oss' => array(
		//bucket 名称
		'bucket'			=>env('BUCKET','nicewine'),
		//地区是深圳oss
		'region'			=>env('REGION','cn-shenzhen'),
		//bucket 地区的访问接口
		'endpoint'			=>env('ENDPOINT','http://oss-cn-shenzhen.aliyuncs.com'),
		//默认cdn域名
		//'file_url'			=>'http://filecdn.oss.nw.txmjiu.com',
		//默认cdn域名
		'img_url'			=>env('IMG_URL','http://test.img2.txmjiu.com'),
		//阿里云的api 授权id.
		'access_key_id'		=>env('ACCESS_KEY_ID','9ez2b71HSQX90fRb'),
		//阿里云的api 授权key
		'access_key_secret'	=>env('ACCESS_KEY_SECRET','gJXjHwip1ulA6elv2Q39EFD8O2ljiW'),
		//阿里云的api 授权角色
		'role_arn'			=>env('ROLE_ARN','acs:ram::31960742:role/aliyunosstokengeneratorrole'),
		//生成授权信息的授权时间
		'token_expire_time'	=>'900',
		//是否使用endpoint
		'is_c_name'			=>false,
		//本服务器是主控服务器，
		//这个参数是子权限使用的
		'security_token'		=>NULL,

		//图片上传时用到
		'host' => env('HOST','http://nicewine.oss-cn-shenzhen.aliyuncs.com')
	)
);
?>