<?php

namespace App\ActionData\PolicyRequest;

use App\ActionData\ActionDataBase;
use App\ActionData\ActionDataFactoryContract;
use Faker\Factory;

class PolicyRequestItemActionData extends ActionDataBase implements ActionDataFactoryContract
{
    public $policy_id;
    public $amount;

    protected array $rules = [
        "policy_id" => "required",
        "amount" => "required|integer|min:1",
    ];

    /**
     * @param int $amount
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function factory(int $amount = 1): array
    {
        $faker = Factory::create();
        $result = [];
        for ($i = 1; $i <= $amount; $i++){
            $result[] = PolicyRequestActionData::createFromArray([
                "policy_id" => 2,
                "amount" => $faker->numberBetween(0, 10000)
            ]);
        }
        return $result;
    }
}
