<?php

namespace App\Services;

use App\ActionData\Attempt\AttemptActionData;
use App\ActionData\Attempt\AttemptUpdateActionData;
use App\ActionResults\CommonActionResult;
use App\ActionResults\VoidActionResult;
use App\Contracts\PaginatorInterface;
use App\DataObjects\Attempt\AttemptDataObject;
use App\DataObjects\DataObjectPagination;
use App\Models\Attempt;
use App\Services\Concerns\Paginator;
use Illuminate\Support\Facades\Auth;

class AttemptService implements PaginatorInterface
{
    use Paginator;

    /**
     * @param AttemptActionData $action_data
     * @return CommonActionResult
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(AttemptActionData $action_data): CommonActionResult {
        $action_data->validate();
        $item = Attempt::query()->create([
            'user_id' => Auth::user()->id,
            'step' => $action_data->step,
            'form_data' => $action_data->form_data
        ]);
        return new CommonActionResult($item->id);
    }

    /**
     * @param AttemptUpdateActionData $action_data
     * @return CommonActionResult
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function update(AttemptUpdateActionData $action_data): CommonActionResult {
        $action_data->validate();
        $item = Attempt::query()->findOrFail($action_data->id);
        $item->updateOrFail([
            'step' => $action_data->step,
            'form_data' => $action_data->form_data
        ]);
        return new CommonActionResult($item->id);
    }

    /**
     * @param int $id
     * @return AttemptDataObject
     */
    public function get(int $id) {
        $item = Attempt::query()->findOrFail($id);
        return new AttemptDataObject($item->toArray());
    }

    /**
     * @param int $id
     * @return VoidActionResult
     */
    public function delete(int $id): VoidActionResult {
        $item = Attempt::query()->findOrFail($id);
        $item->update([
            'is_deleted' => true
        ]);
        return new VoidActionResult();
    }

    /**
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectPagination
     */
    public function paginate(int $page = 1, int $limit = 25, ?iterable $filters = null): DataObjectPagination
    {
        $closure = function ($item) {
            return new AttemptDataObject($item->toArray());
        };

        return $this->filterAndPaginate(
            Attempt::query()
                ->where('is_deleted', '=', false),
            $page,
            $limit,
            $closure,
            $filters
        );
    }
}
