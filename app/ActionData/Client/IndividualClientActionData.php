<?php

namespace App\ActionData\Client;

use App\ActionData\ActionDataBase;

class IndividualClientActionData extends ActionDataBase
{
    public $first_name;
    public $last_name;
    public $middle_name;
    public $passport_seria;
    public $passport_number;
    public $pinfl;
    public $birthday;
    public $passport_issued_by;
    public $passport_issue_date;
    public $gender;
    public $region_id;
    public $district_id;

    protected array $rules = [
        "first_name" => "required",
        "last_name" => "required",
        "middle_name" => "required",
        "pinfl" => "required",
        "passport_seria" => "required",
        "passport_number" => "required",
        "birthday" => "required",
    ];
}
