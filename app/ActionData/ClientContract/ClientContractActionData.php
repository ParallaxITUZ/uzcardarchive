<?php

namespace App\ActionData\ClientContract;

use App\ActionData\ActionDataBase;

class ClientContractActionData extends ActionDataBase
{
    public $product_id;
    public $begin_date;
    public $end_date;
    public $configurations;
    public $client;
    public $objects;
    public $is_web;

    protected array $rules = [
        "product_id" => "required",
        "configurations" => "required|array",
        "client" => "required|array",
        "objects" => "required|array",
        "begin_date" => "required|date",
        "is_web" => "nullable"
    ];
}



