<?php

namespace App\ActionData\PolicyTransfer;

use App\ActionData\ActionDataBase;

class PolicyTransferItemActionData extends ActionDataBase
{
    public $request_item_id;
    public $ranges;

    protected array $rules = [
        "ranges" => "required|array",
        "request_item_id" => "required",
    ];
}
