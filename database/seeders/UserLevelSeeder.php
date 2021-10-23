<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\UserLevel;
use Carbon\Carbon;

class UserLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserLevel::insert([
            'name' => 'DEV',
            'code' => 'dev',
            'description' => 'This is for all developer users',
            'modules' => '1,2,5,8,11,',
            'sub_modules' => '3,4,6,7,9,10,12,13,14',
            'create' => '3,4,6,7,9,10,12,13,14',
            'edit' => '3,4,6,7,9,10,12,13,14',
            'delete' => '3,4,6,7,9,10,12,13,14',
            'import' => '3,4,6,7,9,10,12,13,14',
            'export' => '3,4,6,7,9,10,12,13,14',
            'status' => 1,
            'created_at' => now(),
        ]);
    }
}
