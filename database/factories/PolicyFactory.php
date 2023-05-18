<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\Policy;
use Illuminate\Database\Eloquent\Factories\Factory;

class PolicyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Policy::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'series' => strtoupper($this->faker->randomLetter.$this->faker->randomLetter),
            'template_id' => File::factory(),
        ];
    }
}
