<?php

namespace Database\Factories;

use App\Models\Policy;
use App\Models\PolicyRequestItem;
use App\Models\PolicyTransferItem;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class PolicyTransferItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PolicyTransferItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'from_warehouse_id' => Warehouse::factory(),
            'to_warehouse_id' => Warehouse::factory(),
            'policy_id' => Policy::factory(),
            'series' => strtoupper($this->faker->randomLetter.$this->faker->randomLetter),
            'number_from' => $this->faker->randomNumber(0, 999999),
            'number_to' => $this->faker->randomNumber(0, 999999),
            'axo_user_id' => User::factory(),
            'request_item_id' => PolicyRequestItem::factory(),
            'amount' => $this->faker->randomNumber(0, 1000)
        ];
    }
}
