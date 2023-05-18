<?php

namespace App\Services;

use App\ActionData\Policy\PolicyActionData;
use App\ActionData\Policy\PolicyUpdateActionData;
use App\ActionResults\CommonActionResult;
use App\ActionResults\VoidActionResult;
use App\Contracts\PaginatorInterface;
use App\DataObjects\DataObjectPagination;
use App\DataObjects\Policy\PolicyDataObject;
use App\Models\Policy;
use App\Services\Concerns\Paginator;

class PolicyService implements PaginatorInterface
{
    use Paginator;

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(PolicyActionData $action_data): CommonActionResult
    {
        $action_data->validate();
        $item = Policy::query()->create([
            'display_name' => $action_data->display_name,
            'series' => $action_data->series,
            'form' => $action_data->form,
        ]);
        return new CommonActionResult($item->id);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function update(PolicyUpdateActionData $action_data): CommonActionResult {
        $action_data->validate();
        $policy = Policy::query()->findOrFail($action_data->id);
        $policy->updateOrFail([
            'display_name' => $action_data->display_name,
            'series' => $action_data->series,
            'form' => $action_data->form,
        ]);
        return new CommonActionResult($policy->id);
    }

    /**
     * @param int $id
     * @return VoidActionResult
     * @throws \Throwable
     */
    public function delete(int $id){
        $item = Policy::query()->findOrFail($id);
        $item->updateOrFail([
            'is_deleted' => true
        ]);
        return new VoidActionResult();
    }

    /**
     * @param int $id
     * @return VoidActionResult
     * @throws \Throwable
     */
    public function deactivate(int $id){
        $item = Policy::query()->findOrFail($id);
        $item->updateOrFail([
            'status' => Policy::STATUS_PASSIVE
        ]);
        return new VoidActionResult();
    }

    /**
     * @param int $id
     * @return VoidActionResult
     * @throws \Throwable
     */
    public function activate(int $id){
        $item = Policy::query()->findOrFail($id);
        $item->updateOrFail([
            'status' => Policy::STATUS_ACTIVE
        ]);
        return new VoidActionResult();
    }

    /**
     * @param int $id
     * @return PolicyDataObject
     */
    public function get(int $id){
        $item = Policy::query()->findOrFail($id);
        $result = new PolicyDataObject($item->toArray());
        $result->display_name = json_decode($item->getRawOriginal('display_name'));
        return $result;
    }

    /**
     * @param int $page
     * @param int $limit
     * @param iterable|array|null $filters
     * @return DataObjectPagination
     */
    public function paginate(
        int $page = 1,
        int $limit = 25,
        ?iterable $filters = null
    ): DataObjectPagination
    {
        $closure = function ($item){
            return new PolicyDataObject($item->toArray());
        };

        return $this->filterAndPaginate(
            Policy::query()
                ->orderBy('id')
                ->where('id', '<>', Policy::FOND)
                ->where('is_deleted', '=', false),
            $page,
            $limit,
            $closure,
            $filters
        );
    }
}
