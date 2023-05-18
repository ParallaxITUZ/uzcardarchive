<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class BaseLangFilter
{
    /** @var $filter */
    protected $filter;

    /** @var $column */
    protected $column;

    /** @var $lang */
    public $lang;

    /**
     * @param $filter
     * @param string $column
     * @param string|null $lang
     */
    protected function __construct($filter, string $column, string $lang = null)
    {
        $this->filter = $filter;
        $this->column = $column;
        if ($lang == null){
            $this->lang = app()->getLocale();
        }
    }

    /**
     * @param Builder $model
     * @return Builder
     */
    public function apply(Builder $model): Builder
    {
        return $model->when($this->filter, function (Builder $query) {
            $query->where($this->column.'->' . $this->lang, 'like', $this->filter);
        });
    }

    /**
     * @param $filter
     * @param string $column
     * @param string|null $lang
     * @return \App\Filters\BaseLangFilter
     */
    public static function get($filter, string $column, string $lang = null): self
    {
        return new self($filter, $column, $lang);
    }
}
