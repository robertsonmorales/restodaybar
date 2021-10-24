<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Crypt;

use Carbon\Carbon;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_level_id' => '1',
            'first_name' => $this->faker->firstNameMale,
            'last_name' => $this->faker->lastName,
            'username' => strtolower($this->faker->firstNameMale),
            'contact_number' => "+639".mt_rand(100000000, 999999999),
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password', // $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
            'address' => $this->faker->address,
            'account_status' => 1,
            'ip' => $this->faker->ipv4
        ];
    }
}
