<?php
return array(
    /* oss选项,则需要到aliyun配置 'file_domain' 和 'img_domain' */
    'file_domain_default' => env('FILE_DOMAIN_DEFAULT','local'),    //local or oss

    /* 默认空为使用当前项目域名 */
    'local' => array(
        //文件cdn域名
        'file_domain' => env('LOCAL_FILE_DOMAIN', ''),
        //图片cdn域名
        'img_domain' => env('LOCAL_IMG_DOMAIN', ''),
    ),
);
?>

