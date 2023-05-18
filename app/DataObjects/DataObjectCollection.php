<?php

namespace App\DataObjects;

use Illuminate\Support\Collection;

class DataObjectCollection extends BaseDataObject implements DataObjectContract
{
    /**
     * @var Collection
     */
    public $items;

    public function __construct(iterable $items = [])
    {
        $this->items = $items;
        parent::__construct([]);
    }
}
