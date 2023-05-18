<?php

namespace App\ActionData\OSAGOEpolis;

use App\ActionData\ActionDataBase;

class DetailsActionData extends ActionDataBase
{
    public $issue_date;
    public $start_date;
    public $end_date;
    public $driver_number_destriction;
    public $special_note;
    public $insured_activity_type;


    protected array $rules = [
        "issue_date" => ['required', 'string'],
        "start_date" => ['required', 'string'],
        "end_date" => ['required', 'string'],
        "driver_number_destriction" => ['required', 'boolean', 'max:255'],
        "special_note" => ['string', 'max:255'],
        "insured_activity_type" => ['string', 'max:255'],
    ];
}
