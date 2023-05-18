<?php

namespace App\ActionData\Policy;

use App\ActionData\ActionDataBase;

class PolicyUpdateActionData  extends ActionDataBase
{
    public $id;
    public $display_name;
    public $series;
    public $form;

    protected array $rules = [
        "id" => "required",
        "display_name" => "required",
        "series" => "required",
        "form" => "required",
    ];
}
