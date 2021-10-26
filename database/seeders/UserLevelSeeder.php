<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\UserLevel;

class UserLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserLevel::create([
            'name' => 'Developer',
            'description' => 'This is for all developer users',
            'modules' => '1,2,5,8,11,',
            'sub_modules' => '3,4,6,7,9,10,12,13,14,15,16,17',
            'create' => '3,4,6,7,9,10,12,13,14,15,16,17',
            'edit' => '3,4,6,7,9,10,12,13,14,15,16,17',
            'delete' => '3,4,6,7,9,10,12,13,14,15,16,17',
            'import' => '3,4,6,7,9,10,12,13,14,15,16,17',
            'export' => '3,4,6,7,9,10,12,13,14,15,16,17',
            'status' => 1
        ]);
    }
}
