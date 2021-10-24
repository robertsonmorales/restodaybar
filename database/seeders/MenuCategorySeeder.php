<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class MenuCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_categories')->insert([
            'name' => 'Silog',
            'icon' => 'circle',
            'color_tag' => 'orange',
            'status' => 1
        ]);
        
        DB::table('menu_categories')->insert([
            'name' => 'Sizzling',
            'icon' => 'user-check',
            'color_tag' => 'red',
            'status' => 1
        ]);

        DB::table('menu_subcategories')->insert([
            'menu_category_id' => 1,
            'name' => 'Good for two',
            'status' => 1
        ]);
        
        DB::table('menu_subcategories')->insert([
            'menu_category_id' => 1,
            'name' => 'Family Meal',
            'status' => 1
        ]);

        DB::table('menu_subcategories')->insert([
            'menu_category_id' => 2,
            'name' => 'Family Meal',
            'status' => 1
        ]);
    }
}
