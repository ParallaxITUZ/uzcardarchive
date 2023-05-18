<?php

namespace App\DataObjects\WarehouseItem;

use App\DataObjects\BaseDataObject;

class WarehouseItemDataObject extends BaseDataObject
{
    public $id;
    public $series;
    public $number_from;
    public $number_to;
    public $amount;
    public $transfers;
}
