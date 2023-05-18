<?php

namespace App\DataObjects\DictionaryItem;

use App\DataObjects\BaseDataObject;

class DictionaryItemDataObject extends BaseDataObject
{
    public $id;
    public $display_name;
    public $parent_id;
    public $dictionary_id;
    public $description;
    public $order;
    public $value;
    public $items;
}
