<?php

namespace App\ActionData\Product;

use App\ActionData\ActionDataBase;

class ProductTariffConfigurationActionData  extends ActionDataBase
{
    public $id;
    public $dictionary_item_id;
    public $product_tariff_id;
    public $option_from;
    public $option_to;
    public $value;

    protected array $rules = [
        "dictionary_item_id" => "required",
        "product_tariff_id" => "required",
        "option_from" => "required",
        "option_to" => "required",
        "value" => "required",
    ];
}
