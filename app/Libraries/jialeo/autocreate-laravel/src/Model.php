<?php

namespace JiaLeo\AutoCreate;

use Illuminate\Console\Command;

class Model extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:models';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create all model files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //获取当前所有表
        $tables = array_map('reset', \DB::select('SHOW TABLES'));

        //获取模板文件
        $template = file_get_contents(dirname(__FILE__) . '/template/model.php');

        //model文件目录
        $model_path = app_path() . '/Model';

        //加载helper
        require_once app_path() . '/Helper/File.php';

        foreach ($tables as $key => $v) {
            $class_name = studly_case($v) . 'Model';
            $file_name = $class_name . '.php';
            $file_path = $model_path . '/' . $file_name;

            //判断文件是否存在,存在则跳过
            if (file_exists($file_path)) {
                continue;
            }

            $template_temp = $template;
            $source = str_replace('{{class_name}}', $class_name, $template_temp);
            $source = str_replace('{{table_name}}', $v, $source);

            //写入文件
            if (!dir_exists($model_path)) {
                $this->error('目录' . $model_path . ' 无法写入文件,创建' . $class_name . ' 失败');
                continue;
            }

            if (file_put_contents($file_path, $source)) {
                $this->info($class_name . '添加类成功');
            } else {
                $this->error($class_name . '类写入失败');
            }

        }

    }

}
