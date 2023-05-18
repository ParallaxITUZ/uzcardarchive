<?php

namespace App\ActionData\OSAGOEpolis;

use App\ActionData\ActionDataBase;

class DriverActionData extends ActionDataBase
{
    public $pinfl;
    public $pass_series;
    public $pass_number;
    public $pass_issued_by;
    public $pass_issue_date;
    public $first_name;
    public $last_name;
    public $middle_name;
    public $license_number;
    public $license_seria;
    public $relative;
    public $birthday;
    public $license_issue_date;

    protected array $rules = [
        "pinfl" => ["required", 'string', 'size:14'],
        "pass_series" => ['required', 'string', 'size:2'],
        "pass_number" => ['string', 'size:7'],
        "pass_issued_by" => ['string', 'max:255'],
        "pass_issue_date" => ['date'],
        "first_name" => ['required', 'string', 'max:255'],
        "last_name" => ['required', 'string', 'max:255'],
        "middle_name" => ['required', 'string', 'max:255'],
        "license_seria" => ['required', 'string', 'size:2'],
        "license_number" => ['required', 'string', 'size:7'],
        "relative" => ['integer', 'max:255'],
        "license_issue_date" => ['required', 'date'],
    ];
}
