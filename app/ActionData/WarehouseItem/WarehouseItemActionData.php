<?php

namespace App\ActionData\WarehouseItem;

use App\ActionData\ActionDataBase;

class WarehouseItemActionData extends ActionDataBase
{
    public $id;
    public $warehouse_id;
    public $series;
    public $number_from;
    public $number_to;
    public $amount;

    protected array $rules = [
        "warehouse_id" => "required",
        "series" => "required",
        "number_from" => "required",
        "number_to" => "required",
        "amount" => "required",
    ];
}
