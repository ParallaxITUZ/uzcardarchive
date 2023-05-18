<?php

namespace App\ActionData\Product;

use App\ActionData\ActionDataBase;

class ProductTariffConditionActionData extends ActionDataBase
{
    public $id;
    public $dictionary_id;
    public $product_tariff_id;

    protected array $rules = [
        "dictionary_id" => "required",
        "product_tariff_id" => "required",
    ];
}
