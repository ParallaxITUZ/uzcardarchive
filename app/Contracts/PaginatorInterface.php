<?php

namespace App\Contracts;

use App\DataObjects\DataObjectPagination;

interface PaginatorInterface
{
    /**
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectPagination
     */
    public function paginate(int $page = 1, int $limit = 25, ?iterable $filters = null): DataObjectPagination;
}
