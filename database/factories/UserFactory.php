<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'name' => $this->faker->name(),
            'username' => Str::lower($this->faker->firstName()),
            'email' => $this->faker->unique()->safeEmail(),
            'reviewer' => $this->faker->boolean(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    public function admin($adminCount)
    {
        return $this->state(function (array $attributes) use ($adminCount) {
            $name = 'admin' . $this->faker->unique()->numberBetween(1, $adminCount);
            $email = $name . '@test.com';

            return [
                'name' => $name,
                'username' => $name,
                'email' => $email,
                'role' => 'admin'
            ];
        });
    }
}
