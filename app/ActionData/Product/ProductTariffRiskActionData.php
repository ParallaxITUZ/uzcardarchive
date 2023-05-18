<?php

namespace App\ActionData\Product;

use App\ActionData\ActionDataBase;

class ProductTariffRiskActionData extends ActionDataBase
{
    public $id;
    public $product_tariff_id;
    public $name;
    public $amount;

    protected array $rules = [
        "product_tariff_id" => "required",
        "name" => "required",
        "amount" => "required",
    ];
}
