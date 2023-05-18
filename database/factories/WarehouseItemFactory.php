<?php

namespace Database\Factories;

use App\Models\Policy;
use App\Models\Warehouse;
use App\Models\WarehouseItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class WarehouseItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WarehouseItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'warehouse_id' => Warehouse::factory(),
            'policy_id' => Policy::factory(),
            'series' => strtoupper($this->faker->randomLetter.$this->faker->randomLetter),
            'number_from' => $this->faker->randomNumber(0, 999999),
            'number_to' => $this->faker->randomNumber(0, 999999),
            'amount' => $this->faker->randomNumber(0, 1000)
        ];
    }
}
