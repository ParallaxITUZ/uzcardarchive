<?php

namespace App\ActionData\Permission;

use App\ActionData\ActionDataBase;

class PermissionUpdateActionData extends ActionDataBase
{
    public $id;
    public $name;
    public $display_name;
    public $description;

    protected array $rules = [
        "id" => "required",
        "name" => "required"
    ];
}
