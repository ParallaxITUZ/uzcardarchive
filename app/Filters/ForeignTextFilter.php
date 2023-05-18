<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ForeignTextFilter implements ForeignFilterContract
{
    /** @var $filter */
    protected $filter;

    /** @var $table */
    protected $table;

    /** @var $foreign_key */
    protected $foreign_key;

    /** @var $column */
    protected $column;
    /**
     * @param $filter
     * @param string $table
     * @param string $foreign_key
     * @param string $column
     */
    protected function __construct($filter, string $table, string $foreign_key, string $column)
    {
        $this->filter = $filter;
        $this->table = $table;
        $this->foreign_key = $foreign_key;
        $this->column = $column;
    }

    /**
     * @param Builder $model
     * @return Builder
     */
    public function apply(Builder $model): Builder
    {
        return $model->when($this->filter, function (Builder $query) {
            $query->whereHas($this->table.'.'.$this->foreign_key, function (Builder $builder) {
                $builder->where($this->column, 'like', '%'.$this->filter.'%');
            });
        });
    }

    /**
     * @param $filter
     * @param string $table
     * @param string $foreign_key
     * @param string $column
     * @param string|null $lang
     * @return ForeignTextFilter
     */
    public static function get($filter, string $table, string $foreign_key, string $column, string $lang = null): self
    {
        return new self($filter, $table, $foreign_key, $column);
    }
}
