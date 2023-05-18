<?php

namespace App\ActionResults;

class CommonActionResult extends ActionResultBase
{
    public $id;

    public function __construct(int $id)
    {
        parent::__construct(["id" =>$id]);
    }
}
