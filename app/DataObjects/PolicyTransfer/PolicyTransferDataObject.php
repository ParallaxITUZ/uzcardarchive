<?php

namespace App\DataObjects\PolicyTransfer;

use App\DataObjects\BaseDataObject;

class PolicyTransferDataObject extends BaseDataObject
{
    public $id;
    public $from;
    public $from_warehouse;
    public $to;
    public $to_warehouse;
    public $items;
    public $policy_request;
    public $status;
    public $created_at;
}
