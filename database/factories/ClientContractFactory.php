<?php

namespace Database\Factories;

use App\Models\ClientContract;
use App\Models\Dictionary;
use App\Models\Product;
use App\Models\ProductTariff;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientContractFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClientContract::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $entity_types = Dictionary::query()->where('name', '=', 'entity_types')->first()->items;
        return [
            'product_id' => Product::factory(),
            'product_tariff_id' => ProductTariff::factory(),
            'entity_type_id' => $this->faker->randomElement([

            ]),
            'series',
            'number',
            'begin_date',
            'end_date',
            'configurations',
            'client',
            'objects',
            'amount',
            'risks_sum',
            'file_id',
            'status',
        ];
    }
}
