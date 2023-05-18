<?php

namespace App\DataObjects\Dictionary;

use App\DataObjects\BaseDataObject;

class DictionaryDataObject extends BaseDataObject
{
    public $id;
    public $name;
    public $display_name;
    public $items;
}
