<?php

namespace App\Microservice\DataObjects\Contract;

use App\DataObjects\BaseDataObject;

class ContractDataObject extends BaseDataObject
{
    public $product_id;
    public $begin_date;
    public $end_date;
    public $configurations;
    public $client_id;
    public $client;
    public $objects;
    public $series;
    public $number;
    public $status;
    public $user_id;
}
