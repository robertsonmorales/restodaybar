<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Classes\Sidebar;

class NavigationProvider extends ServiceProvider
{
    public function __construct(){
        $this->sidebar = new Sidebar();
    }
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    
    public function boot()
    {
        return $this->sidebar->index();
    }
}
