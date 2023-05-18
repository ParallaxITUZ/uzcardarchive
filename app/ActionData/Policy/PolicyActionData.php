<?php

namespace App\ActionData\Policy;

use App\ActionData\ActionDataBase;

class PolicyActionData  extends ActionDataBase
{
    public $display_name;
    public $series;
    public $form;

    protected array $rules = [
        "display_name" => "required",
        "series" => "required",
        "form" => "required",
    ];
}
