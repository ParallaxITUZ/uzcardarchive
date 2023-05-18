<?php

namespace App\ActionData;

interface ActionDataFactoryContract
{
    public static function factory(int $amount = 1): array;
}
