<?php

namespace App\ActionData\PolicyTransfer;

use App\ActionData\ActionDataBase;

class PolicyTransferActionData extends ActionDataBase
{
    public $items;
    public $request_id;

    protected array $rules = [
        "request_id" => "required",
        "items" => "required|array",
    ];
}
