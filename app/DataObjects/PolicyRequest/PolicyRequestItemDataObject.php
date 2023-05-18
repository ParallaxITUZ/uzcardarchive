<?php

namespace App\DataObjects\PolicyRequest;

use App\DataObjects\BaseDataObject;

class PolicyRequestItemDataObject extends BaseDataObject
{
    public $id;
    public $policy_id;
    public $policy;
    public $amount;
    public $approved_amount;
}
