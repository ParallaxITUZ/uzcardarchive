<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class BaseFilter implements BaseFilterContract
{
    /** @var $filter */
    protected $filter;

    /** @var $column */
    protected $column;

    /**
     * @param $filter
     * @param string $column
     */
    protected function __construct($filter, string $column)
    {
        $this->filter = $filter;
        $this->column = $column;
    }

    /**
     * @param Builder $model
     * @return Builder
     */
    public function apply(Builder $model): Builder
    {
        return $model->when($this->filter, function (Builder $query) {
            $query->where($this->column, $this->filter);
        });
    }

    /**
     * @param $filter
     * @param string $column
     * @param string|null $lang
     * @return \App\Filters\BaseFilter
     */
    public static function get($filter, string $column, string $lang = null): self
    {
        return new self($filter, $column);
    }
}
