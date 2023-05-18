<?php

namespace App\Services\Concerns;

use App\DataObjects\DataObjectPagination;
use App\Filters\BaseFilterContract;
use App\Filters\ForeignFilterContract;
use Closure;
use Illuminate\Database\Eloquent\Builder;

trait Paginator
{
    /**
     * @param Builder $builder
     * @param int $page
     * @param int $limit
     * @param Closure $closure
     * @param iterable|null $filters
     * @return DataObjectPagination
     */
    private function filterAndPaginate(
        Builder $builder,
        int $page,
        int $limit,
        Closure $closure,
        ?iterable $filters = null
    ): DataObjectPagination
    {
        foreach (collect($filters) as $filter) {
            if ($filter instanceof BaseFilterContract || $filter instanceof ForeignFilterContract) {
                $builder = $filter->apply($builder);
            }
        }

        $builder = $builder->latest()->paginate($limit);

        $items = $builder->getCollection()->transform($closure);

        return new DataObjectPagination($items, $builder->total(), $limit, $page);
    }
}
