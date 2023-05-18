<?php

namespace App\ActionData\OSAGOEpolis;

use App\ActionData\ActionDataBase;

class ObjectActionData extends ActionDataBase
{
    public $techPassportSeria;
    public $techPassportNumber;
    public $techPassportIssueDate;
    public $govNumber;
    public $modelName;
    public $engineNumber;
    public $vehicleTypeId;
    public $issueYear;
    public $bodyNumber;

    protected array $rules = [
        "techPassportSeria" => ['required', 'string'],
        "techPassportNumber" => ['string', 'size:7'],
        "govNumber" => ['required', 'string', 'max:255'],
        "modelName" => "required",
        "vehicleTypeId" => "required",
        "issueYear" => "required",
        "bodyNumber" => "required",
    ];
}
