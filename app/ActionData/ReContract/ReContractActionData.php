<?php

namespace App\ActionData\ReContract;

use App\ActionData\ActionDataBase;

class ReContractActionData extends ActionDataBase
{
    public $old_contract_id;
    public $product_id;
    public $begin_date;
    public $end_date;
    public $configurations;
    public $client_id;
    public $client;
    public $objects;
    public $reason_id;
    public $comment;


    protected array $rules = [
        "product_id" => "required",
        "configurations" => "required|array",
        "client" => "required|array",
        "objects" => "required|array",
        "begin_date" => "required|date",
        "reason_id" => "required",
        "comment" => "required",
    ];
}
