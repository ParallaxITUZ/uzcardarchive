<?php

namespace Database\Factories;

use App\Models\Attempt;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttemptFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attempt::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'step' => rand(1, 5),
            'form_data' => '{}',
            'status' => $this->faker->randomElement([
                Attempt::NOT_DONE,
                Attempt::DONE,
            ])
        ];
    }
}
