<?php

/**
 * 判断目录是否存在
 * @author: 亮 <chenjialiang@han-zi.cn>
 */
if (!function_exists('dir_exists')) {
    function dir_exists($path)
    {
        $f = true;
        if (file_exists($path) == false) {//创建图片目录
            if (mkdir($path, 0777, true) == false)
                $f = false;
            else if (chmod($path, 0777) == false)
                $f = false;
        }

        return $f;
    }
}




