<?php

namespace App\ActionData\DictionaryItem;

use App\ActionData\ActionDataBase;

class DictionaryItemUpdateActionData extends ActionDataBase{
    public $id;
    public $display_name;
    public $order;
    public $description;
    public $value;

    protected array $rules = [
        "id" => "required",
        "display_name" => "required",
    ];
}
