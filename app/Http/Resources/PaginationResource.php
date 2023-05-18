<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use App\Exceptions\ProcedureNotFoundException;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @property Collection $collection
 */
class PaginationResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     * @throws ProcedureNotFoundException
     */
    public function toArray($request): array
    {
        /** @var Builder $model */
        $model = optional($this->collection->first());

        return [
            'items' => $this->collection,
            'meta' => [
                'per_page' => $request->input('pagination.perPage'),
                'page_count' => $this->collection->count(),
                'total_count' => $model->count() ?? 0,
                'last_page' => ceil($model->count() / $request->input('pagination.perPage')),
                'current_page' => $request->input('pagination.page'),
            ]
        ];
    }
}
