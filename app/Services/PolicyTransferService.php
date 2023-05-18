<?php

namespace App\Services;

use App\ActionData\PolicyTransfer\PolicyTransferActionData;
use App\ActionData\PolicyTransfer\PolicyTransferItemActionData;
use App\ActionData\PolicyTransfer\PolicyTransferRangeActionData;
use App\ActionResults\CommonActionResult;
use App\Contracts\PaginatorInterface;
use App\DataObjects\DataObjectPagination;
use App\DataObjects\Policy\PolicyDataObject;
use App\DataObjects\PolicyTransfer\PolicyTransferDataObject;
use App\DataObjects\PolicyTransfer\PolicyTransferItemDataObject;
use App\Models\Organization;
use App\Models\PolicyRequest;
use App\Models\PolicyRequestItem;
use App\Models\PolicyTransfer;
use App\Models\PolicyTransferItem;
use App\Models\WarehouseItem;
use App\Services\Concerns\Paginator;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PolicyTransferService implements PaginatorInterface
{
    use Paginator;

    /**
     * @param PolicyTransferActionData $action_data
     * @return CommonActionResult
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function create(PolicyTransferActionData $action_data)
    {
        try {
            $action_data->validate();
            DB::beginTransaction();
            $policy_request = PolicyRequest::query()->findOrFail($action_data->request_id);
            $transfer = PolicyTransfer::query()->create([
                'from_warehouse_id' => $policy_request->receiver->warehouse->id,
                'to_warehouse_id' => $policy_request->sender->warehouse->id,
                'policy_request_id' => $policy_request->id
            ]);
            $partly = false;
            foreach ($action_data->items as $item){
                $item_action_data = PolicyTransferItemActionData::createFromArray($item);
                $item_action_data->validate();
                $request_item = PolicyRequestItem::query()->findOrFail($item_action_data->request_item_id);
                if ($request_item->approved_amount != $request_item->amount && !$partly){
                    $partly = true;
                }
                $summ = 0;
                foreach ($item_action_data->ranges as $range){
                    $range_action_data = PolicyTransferRangeActionData::createFromArray($range);
                    $range_action_data->validate();
                    $from = WarehouseItem::query()
                        ->where('warehouse_id', '=', $policy_request->sender->warehouse->id)
                        ->where('policy_id', '=', $request_item->policy_id)
                        ->where('series', '=', $range_action_data->series)
                        ->where('number_from', '>', $range_action_data->number_from)
                        ->where('number_to', '<', $range_action_data->number_to)
                        ->first();
                    if (!$from){
                        $from = WarehouseItem::query()->findOrFail(WarehouseItem::FOND);
                    }
                    $warehouse_item = WarehouseItem::query()->create([
                        'warehouse_id' => $transfer->to_warehouse_id,
                        'policy_id' => $request_item->policy_id,
                        'series' => $range_action_data->series,
                        'number_from' => $range_action_data->number_from,
                        'number_to' => $range_action_data->number_to,
                        'amount' => $range_action_data->number_to - $range_action_data->number_from + 1,
                    ]);
                    PolicyTransferItem::query()->create([
                        'policy_transfer_id' => $transfer->id,
                        'from_warehouse_item_id' => $from->id,
                        'to_warehouse_item_id' => $warehouse_item->id,
                        'policy_id' => $request_item->policy_id,
                        'series' => $range_action_data->series,
                        'number_from' => $range_action_data->number_from,
                        'number_to' => $range_action_data->number_to,
                        'axo_user_id' => Auth::user()->id,
                        'amount' => $range_action_data->number_to - $range_action_data->number_from + 1,
                        'request_item_id' => $request_item->id,
                    ]);
                    $summ += $range_action_data->number_to - $range_action_data->number_from + 1;
                }
                if ($summ != $request_item->approved_amount){
                    throw new Exception(__('transfer_approved_amount'));
                }
            }
            if ($partly){
                $policy_request->update([
                    'status' => PolicyRequest::PARTLY_COMPLETED
                ]);
            } else {
                $policy_request->update([
                    'status' => PolicyRequest::COMPLETED
                ]);
            }
            DB::commit();
            return new CommonActionResult($transfer->id);
        } catch (Exception $e){
            DB::rollback();
            throw $e;
        }
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
            $transfer = new PolicyTransferDataObject($item->toArray());
            $transfer->items = [];
            foreach ($item->items as $transfer_item){
                $temp = new PolicyTransferItemDataObject($transfer_item->toArray());
                $temp->policy = new PolicyDataObject($transfer_item->policy->toArray());
                $transfer->items[] = $temp;
            }
            $transfer->from_warehouse = $item->fromWarehouse;
            $transfer->from = $item->fromWarehouse->organization->name;
            $transfer->to_warehouse = $item->toWarehouse;
            $transfer->to = $item->toWarehouse->organization->name;
            $transfer->policy_request = $item->policyRequest;
            return $transfer;
        };

        return $this->filterAndPaginate(
            PolicyTransfer::query(),
            $page,
            $limit,
            $closure,
            $filters
        );
    }

    /**
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectPagination
     * @throws \Exception
     */
    public function paginateSent(int $page = 1, int $limit = 25, ?iterable $filters = null): DataObjectPagination
    {
        if (Auth::user()->profile->organization->organization_type_id == Organization::AGENT){
            throw new Exception("Agents cannot make transfers");
        }
        $closure = function ($item) {
            $transfer = new PolicyTransferDataObject($item->toArray());
            $transfer->items = [];
            foreach ($item->items as $transfer_item){
                $temp = new PolicyTransferItemDataObject($transfer_item->toArray());
                $temp->policy = new PolicyDataObject($transfer_item->policy->toArray());
                $transfer->items[] = $temp;
            }
            $transfer->from_warehouse = $item->fromWarehouse;
            $transfer->from = $item->fromWarehouse->organization->name;
            $transfer->to_warehouse = $item->toWarehouse;
            $transfer->to = $item->toWarehouse->organization->name;
            $transfer->policy_request = $item->policyRequest;
            return $transfer;
        };

        return $this->filterAndPaginate(
            PolicyTransfer::query()
                ->where('from_warehouse_id', Auth::user()->profile->organization->warehouse->id),
            $page,
            $limit,
            $closure,
            $filters
        );
    }

    /**
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectPagination
     */
    public function paginateReceived(int $page = 1, int $limit = 25, ?iterable $filters = null): DataObjectPagination
    {
//        if (Auth::user()->profile->organization->organization_type_id == Organization::AGENT){
//            throw new Exception("Agents cannot make transfers");
//        }
        $closure = function ($item) {
            $transfer = new PolicyTransferDataObject($item->toArray());
            $transfer->items = [];
            foreach ($item->items as $transfer_item){
                $temp = new PolicyTransferItemDataObject($transfer_item->toArray());
                $temp->policy = new PolicyDataObject($transfer_item->policy->toArray());
                $transfer->items[] = $temp;
            }
            $transfer->from_warehouse = $item->fromWarehouse;
            $transfer->from = $item->fromWarehouse->organization->name;
            $transfer->to_warehouse = $item->toWarehouse;
            $transfer->to = $item->toWarehouse->organization->name;
            $transfer->policy_request = $item->policyRequest;
            return $transfer;
        };

        return $this->filterAndPaginate(
            PolicyTransfer::query()
                ->where('to_warehouse_id', Auth::user()->profile->organization->warehouse->id),
            $page,
            $limit,
            $closure,
            $filters
        );
    }

    public function checkIfTransferredFromOne()
    {

        return true;
    }

    public function checkIfTransferredFromMany()
    {

        return true;
    }
}
