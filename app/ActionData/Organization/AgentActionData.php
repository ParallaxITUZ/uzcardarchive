<?php

namespace App\ActionData\Organization;

use App\ActionData\ActionDataBase;

class AgentActionData extends ActionDataBase {
    public $name;
    public $region_id;
    public $parent_id;
    public $agent_type_id;
    public $inn;
    public $pinfl;
    public $account;
    public $address;
    public $director_fio;
    public $director_phone;
    public $product_ids;

//    Contract Data
    public $user_id;
    public $date_from;
    public $date_to;
    public $number;
    public $commission;
    public $signer;
    public $file_id;

//    User Data
    public $login;
    public $password;

    protected array $rules = [
        "name" => "required",
        "region_id" => "required",
        "parent_id" => "required",
        "agent_type_id" => "required",
        "account" => "required",
        "address" => "required",
        "director_fio" => "required",
        "director_phone" => "required",
        "product_ids" => "required|array",

        "login" => ['required', 'string', 'max:255', 'unique:users'],
        "password" => ['required'],
    ];
}
