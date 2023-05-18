<?php

namespace App\ActionData\Organization;

use App\ActionData\ActionDataBase;

class OrganizationUpdateActionData extends ActionDataBase
{
    public $id;
    public $name;
    public $region_id;
    public $inn;
    public $account;
    public $address;
    public $director_fio;
    public $director_phone;

    protected array $rules = [
        "id" => "required",
        "name" => "required",
        "region_id" => "required",
        "inn" => "required",
        "account" => "required",
        "address" => "required",
        "director_fio" => "required",
        "director_phone" => "required",
    ];
}
