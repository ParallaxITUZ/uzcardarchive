<?php

namespace App\ActionData\OSAGOEpolis;

use App\ActionData\ActionDataBase;

class ProvidedDiscountActionData extends ActionDataBase
{
    public $pinfl;
    public $govNumber;

    protected array $rules = [
        "pinfl" => ["required", 'string', 'size:14'],
        "govNumber" => ['required', 'string', 'max:255'],
    ];
}
