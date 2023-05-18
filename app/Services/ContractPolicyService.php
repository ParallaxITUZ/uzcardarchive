<?php

namespace App\Services;

use App\ActionData\ContractPolicy\ContractPolicyActionData;
use App\ActionResults\CommonActionResult;
use App\Contracts\PaginatorInterface;
use App\DataObjects\ClientContract\ContractPolicyDataObject;
use App\DataObjects\DataObjectPagination;
use App\Models\ClientContract;
use App\Models\ContractPolicy;
use App\Services\Concerns\Paginator;

class ContractPolicyService implements PaginatorInterface
{
    /**
     * @param \App\ActionData\ContractPolicy\ContractPolicyActionData $action_data
     * @return \App\ActionResults\CommonActionResult
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(ContractPolicyActionData $action_data)
    {
        $action_data->validate();
        $contract = ClientContract::query()->findOrFail($action_data->contract_id);
        $policy = ContractPolicy::query()->create([
            'contract_id' => $action_data->contract_id,
            'series' => $contract->product->policy->series,
            'number' => ContractPolicy::query()->where('series', $contract->product->policy->series)->max('number') + 1,
        ]);
        return new CommonActionResult($policy->id);
    }

    public function get(int $id)
    {
        $item = ContractPolicy::query()->findOrFail($id);
        $result = new ContractPolicyDataObject($item->toArray());
        $result->contract = $item->contract;
        return $result;
    }

    public function getByContract(int $id)
    {
        $item = ContractPolicy::query()->whereContractId($id)->first();
        $result = new ContractPolicyDataObject($item->toArray());
        $result->contract = $item->contract;
        return $result;
    }

    use Paginator;

    /**
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectPagination
     */
    public function paginate(int $page = 1, int $limit = 25, ?iterable $filters = null): DataObjectPagination
    {
        $closure = function ($item) {
            $result = new ContractPolicyDataObject($item->toArray());
            $result->contract = $item->contract;
            return $result;
        };

        return $this->filterAndPaginate(
            ContractPolicy::query(),
            $page,
            $limit,
            $closure,
            $filters
        );
    }
}
