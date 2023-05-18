<?php

namespace App\ActionData\Warehouse;

use App\ActionData\ActionDataBase;
use App\ActionData\ActionDataFactoryContract;

class ImportActionData extends ActionDataBase implements ActionDataFactoryContract
{
    public $policy_id;
    public $items;

    protected array $rules = [
        "policy_id" => "required",
        "items" => "array|required",
    ];

    public static function factory(int $amount = 1): array
    {
        // TODO: Implement factory() method.
    }
}
