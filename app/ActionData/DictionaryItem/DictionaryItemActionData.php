<?php

namespace App\ActionData\DictionaryItem;

use App\ActionData\ActionDataBase;

class DictionaryItemActionData extends ActionDataBase{
    public $display_name;
    public $dictionary_id;
    public $parent_id;
    public $order;
    public $description;
    public $value;

    protected array $rules = [
        "display_name" => "required",
        "dictionary_id" => "required",
    ];
}
