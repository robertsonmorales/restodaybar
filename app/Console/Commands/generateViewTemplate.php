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
    protected $signature = 'make:view {name}';

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
        $directory = strtolower($this->argument('name'));
        $page_directory = resource_path('views/pages/');
        $fragment_directory = resource_path('views/fragments/');
        $dir = $page_directory . $directory;

        if(file_exists($dir)){
            $this->error('This directory already exists. Please check here resources/views/pages/');
        }else{
            $make_dir = mkdir($dir);
            if($make_dir){ // * create directory based-on input
                $pages = [
                    'index.blade.php', 
                    'form.blade.php'
                ]; // * files to be generate/copied

                for ($i=0; $i < count($pages); $i++) { 
                    $file = $dir . '/' . $pages[$i];
                    $fragment_file = $fragment_directory.$pages[$i];

                    $write_file = fopen($file, 'w');
                    if($write_file){ // * check if creates file
                        $this->info("✓ success creating {$file}");
                        $copy_file = copy($fragment_file, $file);

                        if($copy_file){ // * check if copies file
                            $this->info("✓ success copying: {$fragment_file}");
                        }else{
                            $this->error("✕ failed copying: {$fragment_file}");
                        }

                    }else{
                        $this->error("✕ failed copying: {$file}");
                    }
                }
            }else{
                $this->error("Failed to generate directory: {$directory}");
            }
        }
    }
}
