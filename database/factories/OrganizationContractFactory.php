<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\Organization;
use App\Models\OrganizationContract;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationContractFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrganizationContract::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'organization_id' => Organization::factory(),
            'user_id' => User::factory(),
            'file_id' => File::factory()
        ];
    }
}
