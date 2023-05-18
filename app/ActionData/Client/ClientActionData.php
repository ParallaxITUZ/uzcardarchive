<?php

namespace App\ActionData\Client;

use App\ActionData\ActionDataBase;
use App\ActionData\ActionDataFactoryContract;
use Faker\Factory;

class ClientActionData extends ActionDataBase implements ActionDataFactoryContract
{
    public $entity_type_id;
    public $address;
    public $phone;
    public $registered_user_id;
    public $individual;
    public $legal;

    protected array $rules = [
        "entity_type_id" => "required",
        "address" => "required",
        "phone" => "required",
        "registered_user_id" => "nullable",
        "individual" => "required_without:legal|array",
        "legal" => "required_without:individual|array",
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
            $result[] = ClientActionData::createFromArray([
                "entity_type_id" => "required",
                "address" => $faker->address,
                "phone" => $faker->phoneNumber,
                "registered_user_id" => "required",
                "individual" => IndividualClientActionData::factory(),
                "legal" => LegalClientActionData::factory(),
            ]);
        }
        return $result;
    }
}
