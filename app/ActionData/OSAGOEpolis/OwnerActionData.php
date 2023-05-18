<?php

namespace App\ActionData\OSAGOEpolis;

use App\ActionData\ActionDataBase;

class OwnerActionData extends ActionDataBase
{
    public $pinfl;
    public $passport_series;
    public $passport_number;
    public $passport_issued_by;
    public $passport_issue_date;
    public $first_name;
    public $last_name;
    public $middle_name;
    public $inn;
    public $name;
    public $applicant_is_owner;

    protected array $rules = [
        "pinfl" => ["required_if:applicant_is_owner,false", 'string', 'size:14'],
        "passport_series" => ['required_if:applicant_is_owner,false', 'string', 'size:2'],
        "passport_number" => ['string', 'size:7'],
        "passport_issued_by" => ['string', 'max:255'],
        "passport_issue_date" => ['date'],
        "first_name" => ['required_if:applicant_is_owner,false', 'string', 'max:255'],
        "last_name" => ['required_if:applicant_is_owner,false', 'string', 'max:255'],
        "middle_name" => ['required_if:applicant_is_owner,false', 'string', 'max:255'],
        "applicant_is_owner"=> ['boolean']
    ];
}
