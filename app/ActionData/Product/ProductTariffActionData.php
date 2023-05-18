<?php

namespace App\ActionData\Product;

use App\ActionData\ActionDataBase;

class ProductTariffActionData extends ActionDataBase
{
    public $id;
    public $name;
    public $description;
    public $product_id;

    protected array $rules = [
        "name" => "required",
        "description" => "required",
        "product_id" => "required",
    ];
}
