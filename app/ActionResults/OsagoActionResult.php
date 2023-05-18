<?php

namespace App\ActionResults;

class OsagoActionResult extends ActionResultBase
{
    public $uuid;

    public function __construct(string $uuid)
    {
        parent::__construct(["uuid" =>$uuid]);
    }
}
