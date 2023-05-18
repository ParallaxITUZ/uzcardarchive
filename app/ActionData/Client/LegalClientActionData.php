<?php

namespace App\ActionData\Client;

use App\ActionData\ActionDataBase;

class LegalClientActionData extends ActionDataBase
{
    public $name;
    public $inn;
    public $company;
    public $okonx;
    public $director_fish;
    public $contact_name;
    public $contact_phone;

    protected array $rules = [
        "name" => "required",
        "inn" => "required",
        "contact_phone" => "required",
    ];
}
