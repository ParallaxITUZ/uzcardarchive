<?php

namespace Database\Factories;

use App\Models\PolicyRequest;
use App\Models\PolicyTransfer;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class PolicyTransferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PolicyTransfer::class;

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
            'policy_request_id' => PolicyRequest::factory()
        ];
    }
}
