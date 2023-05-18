<?php

namespace App\ActionData\Permission;

use App\ActionData\ActionDataBase;

class PermissionActionData extends ActionDataBase
{
    public $name;
    public $display_name;
    public $description;

    protected array $rules = [
        "name" => "required"
    ];
}
