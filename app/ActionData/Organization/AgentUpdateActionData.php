<?php

namespace App\ActionData\Organization;

use App\ActionData\ActionDataBase;

class AgentUpdateActionData extends ActionDataBase
{
    public $id;
    public $name;
    public $region_id;
    public $inn;
    public $pinfl;
    public $account;
    public $address;
    public $director_fio;
    public $director_phone;
    public $product_ids;

    protected array $rules = [
        "id" => "required",
        "name" => "required",
        "region_id" => "required",
        "account" => "required",
        "address" => "required",
        "director_fio" => "required",
        "director_phone" => "required",
        "product_ids" => "required|array",
    ];
}
