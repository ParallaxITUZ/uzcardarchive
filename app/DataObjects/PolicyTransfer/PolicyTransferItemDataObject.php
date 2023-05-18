<?php

namespace App\DataObjects\PolicyTransfer;

use App\DataObjects\BaseDataObject;

class PolicyTransferItemDataObject extends BaseDataObject
{
    public $id;
    public $from_warehouse;
    public $from_warehouse_id;
    public $to_warehouse;
    public $to_warehouse_id;
    public $policy;
    public $policy_id;
    public $series;
    public $number_from;
    public $number_to;
    public $user;
    public $user_id;
    public $request;
    public $request_id;
    public $type;
}
