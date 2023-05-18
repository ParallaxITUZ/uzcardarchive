<?php

namespace App\ActionData\Client;

use App\ActionData\ActionDataBase;

class ClientUpdateActionData  extends ActionDataBase
{
    public $id;

    protected array $rules = [
        "id" => "required",
    ];
}
