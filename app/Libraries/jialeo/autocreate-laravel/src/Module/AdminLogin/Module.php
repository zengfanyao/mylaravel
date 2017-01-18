<?php

namespace JiaLeo\AutoCreate\Module\AdminLogin;


class Module
{
    public static function run()
    {
        //获取控制器
        $template_controller = file_get_contents(dirname(__FILE__) . '/LoginController.php');

        //获取逻辑
        $template_logic = file_get_contents(dirname(__FILE__) . '/LoginLogic.php');

        //粘贴
        load_helper('File');

        $controller_path = app_path() . '/Http/Controllers/Admin/';
        $logic_path = app_path() . '/Logic/Admin/';

        if (!dir_exists($controller_path) || !dir_exists($logic_path)) {
            return ['result' => false, 'msg' => '目录不可写'];
        }

        if (!file_put_contents($controller_path . 'LoginController.php', $template_controller)) {
            return ['result' => false, 'msg' => 'LoginController写入失败'];
        }

        if (!file_put_contents($logic_path . 'LoginLogic.php', $template_logic)) {
            return ['result' => false, 'msg' => 'LoginLogic写入失败'];
        }

        //TODO 数据库自动生成

        return true;
    }
}

