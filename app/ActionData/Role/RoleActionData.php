<?php

namespace App\ActionData\Role;

use App\ActionData\ActionDataBase;

class RoleActionData extends ActionDataBase
{
    public $id;
    public $name;
    public $display_name;
    public $description;
    public $permissions;

    protected array $rules = [
        "name" => "required",
        "permissions" => "required|array"
    ];
}
