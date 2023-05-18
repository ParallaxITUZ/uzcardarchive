<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

interface BaseFilterContract
{
    /**
     * @param Builder $model
     * @return Builder
     */
    public function apply(Builder $model): Builder;

    /**
     * @param $filter
     * @param string $column
     * @param string|null $lang
     * @return $this
     */
    public static function get($filter, string $column, string $lang = null): self;
}
