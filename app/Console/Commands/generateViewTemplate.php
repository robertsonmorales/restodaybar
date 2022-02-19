<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class generateViewTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view 
                            {name : name of the module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates view template';

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
     * @return int
     */
    public function handle()
    {
        $directory = strtolower(trim($this->argument('name')));
        $pages = 'resources/views/pages/';

        $dir = $pages . $directory;

        if(file_exists($dir)){
            $this->error('This directory already exists. Please check here resources/views/pages/');
        }else{
            $make_dir = mkdir($dir);
            $source_index = 'resources/views/fragments/index.blade.php';
            $dest_index = $dir . '/' . 'index.blade.php';
            fopen($dest_index, 'w');
            copy($source_index, $dest_index);

            $source_form = 'resources/views/fragments/form.blade.php';
            $dest_form = $dir . '/' . 'form.blade.php';
            fopen($dest_form, 'w');
            copy($source_form, $dest_form);

            $this->info('View template generated successfully!');
        }
    }
}
