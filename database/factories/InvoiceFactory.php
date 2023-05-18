<?php

namespace Database\Factories;

use App\Models\ClientContract;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contract_id' => ClientContract::factory(),
            'series' => strtoupper($this->faker->randomLetter.$this->faker->randomLetter),
            'number' => $this->faker->randomNumber(0, 999999),
            'amount' => $this->faker->randomNumber(1, 1000)
        ];
    }
}
