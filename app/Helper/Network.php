<?php

/**
 * 获取客户ip地址
 * @author: 亮 <chenjialiang@han-zi.cn>
 */
if (!function_exists('get_client_ip')) {
    function get_client_ip($is_to_long = true)
    {
        //是否有设置代理
        if (empty(config('app.proxy_ips'))) {
            Request()->setTrustedProxies(config('app.proxy_ips'));
        }

        $ip = Request()->getClientIp();

        if ($is_to_long) {
            //转为int形式
            $ip = ip2long($ip);
        }

        return $ip;
    }
}




