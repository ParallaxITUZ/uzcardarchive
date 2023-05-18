<?php

namespace App\ActionData\OSAGOEpolis;

use App\ActionData\ActionDataBase;

class OrganizationActionData extends ActionDataBase
{
    public $inn;

    protected array $rules = [
        "inn" => ['string', 'size:9'],
    ];
}
