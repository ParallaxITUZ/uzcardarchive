<?php

namespace App\ActionData\Warehouse;

use App\ActionData\ActionDataBase;

class WarehouseActionData extends ActionDataBase
{
    public $organization_id;

    protected array $rules = [
        "organization_id" => "required",
    ];
}
