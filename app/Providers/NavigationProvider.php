<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use View;
use DB;

class NavigationProvider extends ServiceProvider
{
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
        if (Schema::hasTable('navigations')){
            $userLevels = DB::table('user_levels')->where('status', 1)->get();

            $parentNav = DB::table('navigations')
                ->whereIn('nav_type', ['main', 'single'])
                ->whereAnd('status', 1)
                ->get();
        
            $arr = [];
            foreach ($parentNav as $key => $value) {
                $subNav = DB::table('navigations')
                    ->where(array(
                        'nav_childs_parent_id' => $value->id,
                        'nav_type' => 'sub',
                        'status' => 1
                    ))->get();
                
                $value->sub = $subNav;
            }

            $orderedNavs = json_decode($parentNav, true);

            $navigations = array(
                'navs' => $orderedNavs,
                'user_levels' => $userLevels
            );
            
            View::share('navigations', $navigations);
        }
    }
}
