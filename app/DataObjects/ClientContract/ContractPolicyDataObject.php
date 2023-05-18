<?php

namespace App\DataObjects\ClientContract;

use App\DataObjects\BaseDataObject;

class ContractPolicyDataObject extends BaseDataObject
{
    public $id;
    public $contract;
    public $contract_id;
    public $series;
    public $number;
}
