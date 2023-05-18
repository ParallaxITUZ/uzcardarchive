<?php

namespace App\ViewModels\Admin;

use App\DataObjects\DataObjectCollection;
use App\DataObjects\DataObjectPagination;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginationViewModel
{
    protected $data_collection;
    protected $view_model;

    public $pagination;

    /**
     * PaginationViewModel constructor.
     * @param DataObjectCollection $data_collection
     * @param string $view_model
     */
    public function __construct(DataObjectPagination $data_collection, string $view_model)
    {
        $this->data_collection = $data_collection;
        $this->view_model = $view_model;
        $data_collection->items->transform(function ($value) use ($view_model) {
            return new $view_model($value);
        });
        $parameters = request()->getQueryString();
        $parameters = preg_replace('/&page(=[^&]*)?|^page(=[^&]*)?&?/', '', $parameters);
        $path = url(request()->path()) . (empty($parameters) ? '' : '?' . $parameters);

        $this->pagination = new LengthAwarePaginator($data_collection->items, $data_collection->total_count, $data_collection->limit, $data_collection->page);
        $this->pagination->withPath($path);

        if (isset($data_collection->blocked_members_count)) {
            $this->pagination->blocked_members_count = $data_collection->blocked_members_count;
        }
    }

    /**
     * @param string $view_name
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toView(string $view_name, array $data = [])
    {
        return view($view_name, array_merge(['pagination' => $this->pagination, 'data' => $data]));
    }
}
