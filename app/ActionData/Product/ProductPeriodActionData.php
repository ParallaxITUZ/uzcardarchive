<?php

namespace App\ActionData\Product;

use App\ActionData\ActionDataBase;

class ProductPeriodActionData extends ActionDataBase
{
    public $period_from;
    public $period_to;

    protected array $rules = [
        "period_from" => "required",
        "period_to" => "required"
    ];
}
