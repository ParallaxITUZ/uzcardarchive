<?php

namespace App\ActionData\OSAGOEpolis;

use App\ActionData\ActionDataBase;

class OsagoActionData  extends ActionDataBase
{
    public $autotype;
    public $region;
    public $period;
    public $number_drivers;
    public $discount;
    public $pensioner;

    protected array $rules = [
        "autotype" => "required",
        "region" => "required",
        "period" => "required",
        "number_drivers" => "required",
        "pensioner" => "required|bool",
    ];
}
