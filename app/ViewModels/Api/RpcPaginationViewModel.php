<?php


namespace App\ViewModels\Api;


use App\DataObjects\DataObjectCollection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class RpcPaginationViewModel
 * @author Azizbek Eshonaliyev <1996azizbekeshonaliyev@email.com>
 */
class RpcPaginationViewModel
{
    protected $data_collection;
    protected $view_model;

    public $pagination;
    protected $data;

    /**
     * PaginationViewModel constructor.
     * @param DataObjectCollection $data_collection
     * @param string $view_model
     */
    public function __construct(DataObjectCollection $data_collection, string $view_model)
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
    }

    public function toResponse()
    {
        return $this->pagination;
    }
}
