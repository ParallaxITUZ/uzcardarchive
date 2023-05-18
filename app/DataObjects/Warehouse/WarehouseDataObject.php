<?php

namespace App\DataObjects\Warehouse;

use App\DataObjects\BaseDataObject;

class WarehouseDataObject extends BaseDataObject
{
    public $id;
    public $organization;
    public $organization_id;
    public $items;
}
