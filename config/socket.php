<?php
return [
    //注册者地址
    'set_register_address' => env('SET_REGISTER_ADDRESS','0.0.0.0:21238'),
    'get_register_address' => env('GET_REGISTER_ADDRESS','127.0.0.1:21238'),

    //worker进程数
    'worker_num' => env('SOCKET_WORKER_NUM', 1),

    /********* GATEWAY ***********/

    //gateway地址
    'gateway_address' => env('GATEWAY_ADDRESS', '0.0.0.0:18282'),

    //gateway进程数
    'gateway_count' => env('GATEWAY_COUNT', 1),

    //gateway开始端口,进程有多少个就会增加
    'gateway_start_port' => env('GATEWAY_START_PORT', 22900),

    //本机ip，分布式部署时使用内网ip
    'gateway_lan_ip' => env('GATEWAY_LAN_IP', '127.0.0.1'),

    //请求接口域名
    'api_domain' => env('API_DOMAIN', 'http://10.31.31.32:8002'),
    //请求接口域名
    'socket_key' => env('SOCKET_KEY', 'hanzikeji_mp_aaaa')
];