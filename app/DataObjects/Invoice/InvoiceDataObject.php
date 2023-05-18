<?php

namespace App\DataObjects\Invoice;

use App\DataObjects\BaseDataObject;

class InvoiceDataObject extends BaseDataObject
{
    public $id;
    public $contract_id;
    public $contract;
    public $series;
    public $number;
    public $amount;
    public $payment;
    public $status;
}
