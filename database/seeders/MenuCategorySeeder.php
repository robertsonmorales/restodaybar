<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\{MenuCategory, MenuSubcategory};

class MenuCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = array([
            'name' => 'Silog',
            'icon' => 'circle',
            'color_tag' => 'orange',
            'status' => 1
        ], [
            'name' => 'Sizzling',
            'icon' => 'user-check',
            'color_tag' => 'red',
            'status' => 1
        ]);

        for ($i=0; $i < count($category); $i++) { 
            MenuCategory::create($category[$i]);   
        }

        $subcategory = array([
            'menu_category_id' => 1,
            'name' => 'Good for two',
            'status' => 1
        ], [
            'menu_category_id' => 1,
            'name' => 'Family Meal',
            'status' => 1
        ], [
            'menu_category_id' => 2,
            'name' => 'Family Meal',
            'status' => 1
        ]);

        for ($i=0; $i < count($subcategory); $i++) { 
            MenuSubcategory::create($subcategory[$i]);   
        }
    }
}
