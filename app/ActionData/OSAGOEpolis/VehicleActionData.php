<?php

namespace App\ActionData\OSAGOEpolis;

use App\ActionData\ActionDataBase;

class VehicleActionData extends ActionDataBase
{

    public $techPassportSeria;
    public $techPassportNumber;
    public $govNumber;

    protected array $rules = [
        "techPassportSeria" => ['required', 'string'],
        "techPassportNumber" => ['string', 'size:7'],
        "govNumber" => ['required', 'string', 'max:255'],
    ];
}
