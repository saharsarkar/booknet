<?php

namespace Database\Factories;

use App\Models\GuestComment;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuestCommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GuestComment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(5),
            'content' => $this->faker->realText(100),
            'user_name' => $this->faker->name,
            'created_at' => $this->faker->dateTimeBetween('-1 month')
        ];
    }
}
