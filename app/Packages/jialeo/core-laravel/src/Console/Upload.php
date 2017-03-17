<?php

namespace JiaLeo\Core\Console;

use Illuminate\Console\Command;

class Upload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:upload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold basic upload and routes';

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
    public function fire()
    {
        $this->createDirectories();

        file_put_contents(
            base_path('routes/api.php'),
            file_get_contents(__DIR__.'/stubs/upload/routes.stub'),
            FILE_APPEND
        );

        //控制器
        $controller_file = app_path('Http/Controllers/Admin/UploadController.php');
        if(file_exists($controller_file)){
            $this->error($controller_file.'文件已存在!');
        }

        file_put_contents(
            $controller_file,
            file_get_contents(__DIR__.'/stubs/upload/UploadController.stub')
        );
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    public function createDirectories()
    {
        load_helper('File');
        file_exists(app_path('Http/Controllers/Admin'));

    }

}
