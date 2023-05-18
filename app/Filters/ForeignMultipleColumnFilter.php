<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ForeignMultipleColumnFilter implements ForeignMultipleColumnFilterContract
{
    /** @var $filter */
    protected $filter;

    /** @var $table */
    protected $table;

    /** @var $foreign_key */
    protected $foreign_key;

    /** @var $columns */
    protected $columns;
    /**
     * @param $filter
     * @param string $table
     * @param string $foreign_key
     * @param array $columns
     */
    protected function __construct($filter, string $table, string $foreign_key, array $columns)
    {
        $this->filter = $filter;
        $this->table = $table;
        $this->foreign_key = $foreign_key;
        $this->columns = $columns;
    }

    /**
     * @param Builder $model
     * @return Builder
     */
    public function apply(Builder $model): Builder
    {
        return $model->when($this->filter, function (Builder $query) {
            $query->whereHas($this->table.'.'.$this->foreign_key, function (Builder $builder) {
                foreach ($this->columns as $column){
                    $builder->orWhere($column, 'like', '%'.$this->filter.'%');
                }
            });
        });
    }

    /**
     * @param $filter
     * @param string $table
     * @param string $foreign_key
     * @param array $columns
     * @param string|null $lang
     * @return \App\Filters\ForeignMultipleColumnFilter
     */
    public static function get($filter, string $table, string $foreign_key, array $columns, string $lang = null): self
    {
        return new self($filter, $table, $foreign_key, $columns);
    }
}
