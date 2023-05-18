<?php

namespace App\DataObjects;

use Illuminate\Support\Collection;

/**
 * @property $error
 */
class DataObjectPagination extends BaseDataObject implements DataObjectContract
{
    /**
     * @var Collection
     */
    public $items;
    public $total_count;
    public $limit;
    public $page;

    public function __construct(?Collection $items = null, int $total_count = 0, int $limit = 25, int $page = 1)
    {
        $this->items = $items;
        $this->total_count = $total_count;
        $this->limit = $limit;
        $this->page = $page;
        parent::__construct([]);
    }
}
