<?php

namespace App\ActionData\OSAGOEpolis;

use App\ActionData\ActionDataBase;

class PinflActionData extends ActionDataBase
{
    public $passportSeries;
    public $passportNumber;
    public $pinfl;

    protected array $rules = [
        "passportSeries" => ['required'],
        "passportNumber" => ['required'],
        "pinfl" => ['required']
    ];
}
