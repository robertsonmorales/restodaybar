<?php

namespace App\Http\Classes;

use Schema, View, DB;

use App\Models\{UserLevel, Navigation};

class Sidebar {
    public function __construct(){
        $this->userLevel = new UserLevel();
        $this->navigation = new Navigation();
    }

    public function index(){
        if (Schema::hasTable('navigations')){
            $userLevels = $this->userLevel->active()->get();
            $parentNav = $this->navigation->isSingleOrMain()->activeNav()->get();

            foreach ($parentNav as $key => $value) {
                $subNav = $this->navigation->where(array(
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