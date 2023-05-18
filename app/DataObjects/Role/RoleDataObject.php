<?php

namespace App\DataObjects\Role;

use App\DataObjects\BaseDataObject;

class RoleDataObject extends BaseDataObject
{
    public $id;
    public $name;
    public $display_name;
    public $description;
    public $permissions;
}
