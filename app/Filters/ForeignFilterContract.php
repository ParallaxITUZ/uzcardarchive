<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

interface ForeignFilterContract
{
    /**
     * @param Builder $model
     * @return Builder
     */
    public function apply(Builder $model): Builder;

    /**
     * @param $filter
     * @param string $table
     * @param string $foreign_key
     * @param string $column
     * @param string|null $lang
     * @return $this
     */
    public static function get($filter, string $table, string $foreign_key, string $column, string $lang = null): self;
}
