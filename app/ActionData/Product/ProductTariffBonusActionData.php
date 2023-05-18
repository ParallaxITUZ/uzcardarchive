<?php

namespace App\ActionData\Product;

use App\ActionData\ActionDataBase;

class ProductTariffBonusActionData  extends ActionDataBase
{
    public $id;
    public $dictionary_item_id;
    public $product_tariff_condition_id;
    public $name;
    public $value;

    protected array $rules = [
        "dictionary_item_id" => "required",
        "product_tariff_condition_id" => "required",
        "name" => "required",
        "value" => "required",
    ];
}
