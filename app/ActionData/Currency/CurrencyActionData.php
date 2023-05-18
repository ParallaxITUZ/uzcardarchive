<?php

namespace App\ActionData\Currency;

use App\ActionData\ActionDataBase;

class CurrencyActionData  extends ActionDataBase
{
    public $id;
    public $name;
    public $rate;
    public $code;
    public $date;

    protected array $rules = [
        "name" => "required",
        "rate" => "required",
        "code" => "required",
        "date" => "required"
    ];
}
