<?php

namespace App\DataObjects\Permission;

use App\DataObjects\BaseDataObject;

class PermissionDataObject extends BaseDataObject
{
    public $id;
    public $name;
    public $display_name;
    public $description;
}
