<?php

namespace App\Services;

use App\ActionData\Warehouse\ImportActionData;
use App\ActionData\Warehouse\ImportItemActionData;
use App\ActionResults\CommonActionResult;
use App\Contracts\PaginatorInterface;
use App\DataObjects\DataObjectPagination;
use App\DataObjects\Warehouse\WarehouseDataObject;
use App\DataObjects\WarehouseItem\PolicyWarehouseDataObject;
use App\DataObjects\WarehouseItem\WarehouseItemDataObject;
use App\Exceptions\NotFoundException;
use App\Models\Organization;
use App\Models\Policy;
use App\Models\PolicyRequest;
use App\Models\PolicyRequestItem;
use App\Models\PolicyTransfer;
use App\Models\PolicyTransferItem;
use App\Models\Warehouse;
use App\Models\WarehouseItem;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Services\Concerns\Paginator;
use Illuminate\Support\Facades\DB;

class WarehouseService implements PaginatorInterface
{
    use Paginator;

    /**
     * @var PolicyTransferService
     */
    protected $transfer_service;

    /**
     * WarehouseService constructor.
     * @param PolicyTransferService $transfer_service
     */
    public function __construct(PolicyTransferService $transfer_service)
    {
        $this->transfer_service = $transfer_service;
    }

    /**
     * @param int $id
     * @throws \App\Exceptions\NotFoundException
     */
    public function create(int $id){
        if ($organization = Organization::query()->find($id)){
            Warehouse::query()->create(['organization_id' => $organization->id]);
        } else {
            throw new NotFoundException("Organization with id=$id not found");
        }
    }

    /**
     * @param \App\ActionData\Warehouse\ImportActionData $action_data
     * @return \App\ActionResults\CommonActionResult
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function import(ImportActionData $action_data)
    {
        try {
            $action_data->validate();
            DB::beginTransaction();
            $policy_request = PolicyRequest::query()->findOrFail(PolicyRequest::IMPORT);
            $transfer = PolicyTransfer::query()->create([
                'from_warehouse_id' => $policy_request->receiver->warehouse->id,
                'to_warehouse_id' => $policy_request->sender->warehouse->id,
                'policy_request_id' => $policy_request->id
            ]);
            foreach ($action_data->items as $item){
                $item_action_data = ImportItemActionData::createFromArray($item);
                $item_action_data->validate();
//                $from = WarehouseItem::query()
//                    ->where('warehouse_id', '=', $policy_request->receiver->warehouse->id)
//                    ->where('policy_id', '=', $action_data->policy_id)
//                    ->where('series', '=', $item_action_data->series)
//                    ->where('number_from', '>', $action_data->number_from)
//                    ->where('number_to', '<', $action_data->number_to)
//                    ->first();
//                $to = WarehouseItem::query()
//                    ->where('warehouse_id', '=', $policy_request->sender->warehouse->id)
//                    ->where('policy_id', '=', $action_data->policy_id)
//                    ->where('series', '=', $item_action_data->series)
//                    ->where('number_from', '>', $action_data->number_from)
//                    ->where('number_to', '<', $action_data->number_to)
//                    ->first();

                $warehouse_item = WarehouseItem::query()->create([
                    'warehouse_id' => $transfer->to_warehouse_id,
                    'policy_id' => $action_data->policy_id,
                    'series' => $item_action_data->series,
                    'number_from' => $item_action_data->number_from,
                    'number_to' => $item_action_data->number_to,
                    'amount' => $item_action_data->number_to - $item_action_data->number_from + 1,
                ]);
                PolicyTransferItem::query()->create([
                    'policy_transfer_id' => $transfer->id,
                    'from_warehouse_item_id' => WarehouseItem::FOND,
                    'to_warehouse_item_id' => $warehouse_item->id,
                    'policy_id' => $action_data->policy_id,
                    'series' => $item_action_data->series,
                    'number_from' => $item_action_data->number_from,
                    'number_to' => $item_action_data->number_to,
                    'axo_user_id' => Auth::user()->id,
                    'amount' => $item_action_data->number_to - $item_action_data->number_from + 1,
                    'request_item_id' => PolicyRequestItem::IMPORT,
                ]);
            }
            DB::commit();
            return new CommonActionResult($transfer->id);
        } catch (Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function checkIfExists(int $warehouse_id, int $number_from, int $number_to)
    {
        $in = WarehouseItem::query()
            ->where('warehouse_id', $warehouse_id)
            ->where('number_from', '<=' , $number_from)
            ->where('number_to', '>=' , $number_to)
            ->first();
        if ($in && $in->status == WarehouseItem::STATUS_ACTIVE && $in->amount > 0)
            return !$this->transfer_service->checkIfTransferredFromOne($in->id, $number_from, $number_to);
        else {
            $from = WarehouseItem::query()
                ->where('warehouse_id', $warehouse_id)
                ->where('number_from', '<=' , $number_from)
                ->first();
        }
        return false;
    }

    /**
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectPagination
     */
    public function paginateItems(int $page = 1, int $limit = 25, ?iterable $filters = null): DataObjectPagination
    {
        $closure = function ($item) {
            $warehouse_items = WarehouseItem::query()
                ->where('warehouse_id', Auth::user()->profile->organization->warehouse->id)
                ->where('policy_id', $item->id)
                ->where('amount', '>', 0)
                ->where('status', Policy::STATUS_ACTIVE)
                ->orderBy('number_from', 'ASC')
                ->get();

            $result = new PolicyWarehouseDataObject($item->toArray());
            $result->name = $item->display_name;
            $result->warehouse_items = [];
            foreach ($warehouse_items as $warehouse_item){
                $warehouse_item_data_object = new WarehouseItemDataObject($warehouse_item->toArray());
                $warehouse_item_data_object->transfers = $warehouse_item->send;
                $result->warehouse_items[] = $warehouse_item_data_object;
            }
            return $result;
        };

        return $this->filterAndPaginate(
            Policy::query()->where('id', '<>', Policy::FOND),
            $page,
            $limit,
            $closure,
            $filters
        );
    }

//    public function transfer()
//    {
//        $warehouse_item = WarehouseItem::query()->findOrFail(1);
//        $warehouse_item_data_object = new WarehouseItemDataObject($warehouse_item->toArray());
//        $warehouse_item_data_object->transfers = $warehouse_item->send;
//        dd($warehouse_item_data_object);
//
//        $transfer = PolicyTransfer::query()->create([
//            'from_warehouse_id' => 1,
//            'to_warehouse_id' => 2,
//            'policy_request_id' => 0
//        ]);
//        $item = WarehouseItem::query()->create([
//            'warehouse_id' => $transfer->to_warehouse_id,
//            'policy_id' => 2,
//            'series' => "EKFL",
//            'number_from' => 1001,
//            'number_to' => 5000,
//            'amount' => 4000,
//        ]);
//        $ware = WarehouseItem::query()->findOrFail(1);
//        $ware->update([
//            'amount' => $ware->amount-4000,
//        ]);
//        PolicyTransferItem::query()->create([
//            'policy_transfer_id' => $transfer->id,
//            'from_warehouse_item_id' => $ware->id,
//            'to_warehouse_item_id' => $item->id,
//            'policy_id' => 2,
//            'series' => "EKFL",
//            'number_from' => 1001,
//            'number_to' => 5000,
//            'amount' => 4000,
//            'axo_user_id' => 1,
//            'request_item_id' => 0
//        ]);
//
//    }

    /**
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectPagination
     */
    public function paginate(int $page = 1, int $limit = 25, ?iterable $filters = null): DataObjectPagination
    {
        $closure = function ($item) {
            return new WarehouseDataObject($item->toArray());
        };

        return $this->filterAndPaginate(
            Warehouse::query(),
            $page,
            $limit,
            $closure,
            $filters
        );
    }
}
