<?php

namespace App\ActionData\Organization;

use App\ActionData\ActionDataBase;

class OrganizationActionData extends ActionDataBase
{
    public $name;
    public $region_id;
    public $parent_id;
    public $inn;
    public $account;
    public $address;
    public $director_fio;
    public $director_phone;
    public $file_id;

//    User Data
    public $login;
    public $password;

    protected array $rules = [
        "name" => "required",
        "region_id" => "required",
        "parent_id" => "required",
        "inn" => "required",
        "account" => "required",
        "address" => "required",
        "director_fio" => "required",
        "director_phone" => "required",
        "file_id" => "required",

        "login" => ['required', 'string', 'max:255', 'unique:users'],
        "password" => ['required'],
    ];
}
