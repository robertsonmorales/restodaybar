<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(20)->create();

        User::create([
            'first_name' => 'robert',
            'last_name' => 'morales',
            'username' => 'robert',
            'contact_number' => '+639123456789',
            'email' => 'moralesso152842@gmail.com',
            'password' => '7ujm&UJM',
            'user_level_id' => '1',
            'address' => 'Northern Samar',
            'account_status' => 1
        ]);
    }
}
