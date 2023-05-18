<?php

namespace App\ActionData\Invoice;

use App\ActionData\ActionDataBase;

class InvoiceActionData extends ActionDataBase
{
    public $type;
    public $currency;
    public $invoice_id;

    protected array $rules = [
        "type" => "required",
        "currency" => "required",
        "invoice_id" => "required",
    ];
}
