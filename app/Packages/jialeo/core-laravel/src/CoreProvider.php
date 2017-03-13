<?php

namespace JiaLeo\Core;

use Illuminate\Support\ServiceProvider;

class CoreProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //加载核心辅助函数
        require_once __DIR__.'/Hepler.php';

        //调试模式
        if(config('app.debug') === true){
            //注册路由
            if (!$this->app->routesAreCached()) {
                require __DIR__ . '/routes/debug.php';
            }
            new \JiaLeo\Core\Debuger();
        }

        //注册自动生成命令
        if ($this->app->runningInConsole()) {
            $this->commands([
                'JiaLeo\Core\Console\Model',
                'JiaLeo\Core\Console\ModelDoc',
                'JiaLeo\Core\Console\Controller',
                'JiaLeo\Core\Console\Logic',
                'JiaLeo\Core\Console\Module',
                'JiaLeo\Core\Console\Config',
                'JiaLeo\Core\Console\Supervisor'
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
