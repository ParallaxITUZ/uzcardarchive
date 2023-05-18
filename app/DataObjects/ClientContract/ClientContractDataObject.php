<?php

namespace App\DataObjects\ClientContract;

use App\DataObjects\BaseDataObject;

class ClientContractDataObject extends BaseDataObject
{
    public $id;
    public $product_id;
    public $product_tariff_id;
    public $begin_date;
    public $end_date;
    public $product;
    public $entity_type;
    public $configurations;
    public $client;
    public $objects;
    public $invoice;
    public $payment;
    public $file;
    public $amount;
    public $risks_sum;
    public $series;
    public $number;
    public $status;
}
