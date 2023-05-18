<?php

namespace App\ActionData\Warehouse;

use App\ActionData\ActionDataBase;
use App\ActionData\ActionDataFactoryContract;

class ImportItemActionData extends ActionDataBase implements ActionDataFactoryContract
{
    public $series;
    public $number_from;
    public $number_to;

    protected array $rules = [
        "series" => "required",
        "number_from" => "required",
        "number_to" => "required",
    ];

    public static function factory(int $amount = 1): array
    {
        // TODO: Implement factory() method.
    }
}
