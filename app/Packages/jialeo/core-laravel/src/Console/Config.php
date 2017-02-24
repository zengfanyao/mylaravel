<?php

namespace JiaLeo\Core\Console;

use Illuminate\Console\Command;

class Config extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:env';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a .env file for the developing environment';

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
        passthru('sh '.base_path('config.sh'));
    }
}
