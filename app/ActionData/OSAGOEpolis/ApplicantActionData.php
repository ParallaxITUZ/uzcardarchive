<?php


namespace App\ActionData\OSAGOEpolis;


use App\ActionData\ActionDataBase;

class ApplicantActionData extends ActionDataBase
{
    public $pinfl;
    public $pass_series;
    public $pass_number;
    public $pass_issued_by;
    public $pass_issue_date;
    public $firstname;
    public $lastname;
    public $middlename;
    public $phone_number;
    public $gender;
    public $birth_date;
    public $region_id;
    public $district_id;
    public $address;
    public $email;
    public $org_inn;
    public $org_name;

    protected array $rules = [
        "pinfl" => ["required", 'string', 'size:14'],
        "pass_series" => ['required', 'string', 'size:2'],
        "pass_number" => ['string', 'size:7'],
        "pass_issued_by" => ['string', 'max:255'],
        "pass_issue_date" => ['date'],
        "firstname" => ['required', 'string', 'max:255'],
        "lastname" => ['required', 'string', 'max:255'],
        "middlename" => ['required', 'string', 'max:255'],
        "phone_number" => ['required', 'string', 'max:255'],
        "gender" => ['string', 'max:255'],
        "birth_date" => ['required', 'date'],
        "region_id" => ['required', 'integer'],
        "district_id" => ['required', 'integer'],
        "address" => ['required', 'string', 'max:255'],
        "email" => ['string', 'max:255'],
        "org_inn" => ['required', 'string', 'size:7'],
        "org_name" => ['required', 'string', 'max:255'],
    ];
}
