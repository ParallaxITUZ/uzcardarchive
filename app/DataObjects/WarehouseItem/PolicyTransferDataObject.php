<?php

namespace App\DataObjects\WarehouseItem;

use App\DataObjects\BaseDataObject;

class PolicyTransferDataObject extends BaseDataObject
{
    public $id;
    public $from_warehouse_item_id;
    public $from_warehouse_item;
    public $to_warehouse_item_id;
    public $to_warehouse_item;
    public $series;
    public $number_from;
    public $number_to;
    public $amount;
    public $type;
    public $status;
}
