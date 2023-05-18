<?php

namespace App\ActionData\PolicyRequest;

use App\ActionData\ActionDataBase;
use App\ActionData\ActionDataFactoryContract;
use Faker\Factory;

class PolicyRequestUpdateActionData extends ActionDataBase implements ActionDataFactoryContract
{
    public $id;
    public $delivery_date;
    public $comment;
    public $items;
    public static $items_amount;

    protected array $rules = [
        "id" => "required",
        "delivery_date" => "required",
        "items" => "required|array",
    ];

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function factory(int $amount = 1): array
    {
        $faker = Factory::create();
        $result = [];
        for ($i = 1; $i <= $amount; $i++){
            $result[] = PolicyRequestActionData::createFromArray([
                "delivery_date" => $faker->dateTime(),
                "items" => PolicyRequestItemActionData::factory(self::$items_amount),
            ]);
        }
        return $result;
    }

    public static function items(int $amount)
    {
        self::$items_amount = $amount;
        return new static;
    }
}
