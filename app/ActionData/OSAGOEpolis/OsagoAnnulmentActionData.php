<?php

namespace App\ActionData\OSAGOEpolis;

use App\ActionData\ActionDataBase;

class OsagoAnnulmentActionData extends ActionDataBase
{
    public $insuranceFormUuid;
    public $refundAmount;
    public $insurancePremium;
    public $terminationDate;

    protected array $rules = [
        "insuranceFormUuid" => ['required'],
        "refundAmount" => ['required'],
        "insurancePremium" => ['required'],
        "terminationDate" => ['required']
    ];
}
