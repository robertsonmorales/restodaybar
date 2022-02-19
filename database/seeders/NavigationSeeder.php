<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Navigation;
use Carbon\Carbon;

class NavigationSeeder extends Seeder
{
    protected $nav;
    public function __construct(Navigation $nav){
        $this->nav = $nav;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $navs = array(
            array(
                'main' => array('Dashboard', 'dashboard', 'Dashboard', 'activity', 'single')
            ),
            array(
                'main' => array('Settings', 'settings', '', 'settings', 'main'),
                'sub' => array(
                    array('System Settings', 'system', 'Settings\System', 'circle', 'sub'),
                    array('Navigations', 'navigations', 'Settings\Navigation', 'circle', 'sub')
                )
            ),
            array(
                'main' => array('Module Management', 'modules_mangement', 'ModuleManagement', 'folder', 'single')
            ),
            array(
                'main' => array('User Management', 'user_management', '', 'users', 'main'),
                'sub' => array(
                    array('User Accounts', 'user_accounts', 'UserAccount', 'circle', 'sub'),
                    array('User Levels', 'user_levels', 'UserLevel', 'circle', 'sub')
                )
            ),
            array(
                'main' => array('System Logs', 'system_logs', '', 'server', 'main'),
                'sub' => array(
                    array('Audit Trail Logs', 'audit_trail_logs', 'AuditTrailLog', 'circle', 'sub'),
                    array('API Logs', 'api_logs', 'APILogs', 'circle', 'sub')
                )
            ),
            array(
                'main' => array('Maintenance', 'maintenance', '', 'tool', 'main'),
                'sub' => array(
                    array('Menu Categories', 'menu_categories', 'Maintenance\MenuCategory', 'circle', 'sub'),
                    array('Menu Subcategories', 'menu_subcategories', 'Maintenance\MenuSubcategory', 'circle', 'sub'),
                    array('Menus', 'menus', 'Maintenance\Menu', 'circle', 'sub'),
                    array('Table Management', 'table_management', 'Maintenance\TableManagement', 'circle', 'sub'),
                )
            )
        );

        $this->insertNavigation($navs);
    }

    public function insertNavigation($navs){
        for ($i=0; $i < count($navs); $i++) { 
            $nav = $navs[$i];

            $parent_navs = array(
                'nav_name' => $nav['main'][0],
                'nav_route' => $nav['main'][1],
                'nav_controller' => $nav['main'][2],
                'nav_icon' => $nav['main'][3],
                'nav_type' => $nav['main'][4],
                'nav_order' => $i + 1,
            );

            $parent = $this->nav->create($parent_navs);
            $parent_id = $parent->id;

            if(isset($nav['sub'])){
                for ($j=0; $j < count($nav['sub']); $j++) { 
                    $child_navs = array(
                        'nav_name' => $nav['sub'][$j][0],
                        'nav_route' => $nav['sub'][$j][1],
                        'nav_controller' => $nav['sub'][$j][2],
                        'nav_icon' => $nav['sub'][$j][3],
                        'nav_type' => $nav['sub'][$j][4],
                        'nav_suborder' => $j + 1,
                        'nav_childs_parent_id' => $parent_id
                    );

                    $this->nav->create($child_navs);
                }
            }
        }
    }
}
