<?php

namespace App\Services;

use App\ActionData\PolicyRequest\PolicyRequestActionData;
use App\ActionData\PolicyRequest\PolicyRequestApproveActionData;
use App\ActionData\PolicyRequest\PolicyRequestItemActionData;
use App\ActionData\PolicyRequest\PolicyRequestItemApproveActionData;
use App\ActionData\PolicyRequest\PolicyRequestUpdateActionData;
use App\ActionResults\CommonActionResult;
use App\ActionResults\VoidActionResult;
use App\Contracts\PaginatorInterface;
use App\DataObjects\DataObjectPagination;
use App\DataObjects\PolicyRequest\PolicyRequestDataObject;
use App\DataObjects\PolicyRequest\PolicyRequestItemDataObject;
use App\Models\Organization;
use App\Models\PolicyRequest;
use App\Models\PolicyRequestItem;
use App\Services\Concerns\Paginator;
use App\Structures\RpcErrors;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PolicyRequestService implements PaginatorInterface
{
    use Paginator;

    /**
     * @param PolicyRequestActionData $action_data
     * @return CommonActionResult
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function create(PolicyRequestActionData $action_data): CommonActionResult {
        try {
            $action_data->validate();
            if (Auth::user()->profile->organization->organization_type_id == Organization::COMPANY){
                throw new Exception("Organization can't send requests");
            }
            DB::beginTransaction();
            $policy_request = PolicyRequest::query()->create([
                'sender_id' => Auth::user()->profile->organization_id,
                'receiver_id' => Auth::user()->profile->organization->parent_id,
                'requested_user_id' => Auth::user()->id,
                'status' => PolicyRequest::CREATED,
                'delivery_date' => $action_data->delivery_date,
                'comment' => $action_data->comment
            ]);
            foreach ($action_data->items as $item){
                $request_item = PolicyRequestItemActionData::createFromArray($item);
                $request_item->validate();
                if ($request_item->amount < 1){
                    throw new Exception('Amount cannot be less than 1');
                }
                PolicyRequestItem::query()->create([
                    'policy_request_id' => $policy_request->id,
                    'policy_id' => $request_item->policy_id,
                    'amount' => $request_item->amount,
                ]);
            }
            DB::commit();
            return new CommonActionResult($policy_request->id);
        } catch (Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    /**
     * @param PolicyRequestUpdateActionData $action_data
     * @return CommonActionResult
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function update(PolicyRequestUpdateActionData $action_data): CommonActionResult {
        try {
            $action_data->validate();
            DB::beginTransaction();
            $policy_request = PolicyRequest::query()->findOrFail($action_data->id);
            if ($policy_request->status != PolicyRequest::CREATED){
                throw new Exception('Cannot change this request because of this is already in processing!');
            }
            $policy_request->update([
                'delivery_date' => $action_data->delivery_date,
                'comment' => $action_data->comment
            ]);
            $items = PolicyRequestItem::query()->where('policy_request_id', $action_data->id)->get();
            foreach ($items as $item){
                $item->delete();
            }
            foreach ($action_data->items as $item){
                $request_item = PolicyRequestItemActionData::createFromArray($item);
                $request_item->validate();
                if ($request_item->amount < 1){
                    throw new Exception('Amount cannot be less than 1');
                }
                PolicyRequestItem::query()->create([
                    'policy_request_id' => $policy_request->id,
                    'policy_id' => $request_item->policy_id,
                    'amount' => $request_item->amount,
                ]);
            }
            DB::commit();
            return new CommonActionResult($policy_request->id);
        } catch (Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    /**
     * @param int $id
     * @return \App\ActionResults\VoidActionResult
     * @throws \Exception
     */
    public function delete(int $id){
        $request = PolicyRequest::query()->findOrFail($id);
        if ($request->status == PolicyRequest::CREATED){
            $request->update([
                'is_deleted' => true
            ]);
        } else {
            throw new Exception('Cannot delete request when it\'s under process');
        }
        return new VoidActionResult();
    }

    /**
     * @param int $id
     * @return \App\ActionResults\VoidActionResult
     * @throws \Exception
     */
    public function reject(int $id){
        $request = PolicyRequest::query()->findOrFail($id);
        if ($request->status != PolicyRequest::COMPLETED && $request->status != PolicyRequest::PARTLY_COMPLETED){
            $request->update([
                'status' => PolicyRequest::REJECTED
            ]);
        } else {
            throw new Exception('Cannot reject request when it\'s done already');
        }
        return new VoidActionResult();
    }

    /**
     * @param int $id
     * @return \App\DataObjects\PolicyRequest\PolicyRequestDataObject
     */
    public function get(int $id){
        $item = PolicyRequest::query()->findOrFail($id);
        $result = new PolicyRequestDataObject($item->toArray());
        $result->items = $this->itemsToDataObjects($item->items);
        $result->sender = $item->sender;
        $result->receiver = $item->receiver;
        $result->requested_user = $item->requester;
        $result->approved_user = $item->approver;
        return $result;
    }

    /**
     * @param int $id
     * @return \App\DataObjects\PolicyRequest\PolicyRequestDataObject
     * @throws \Exception
     */
    public function getApproved(int $id){
        $item = PolicyRequest::query()->findOrFail($id);
        if ($item->status != PolicyRequest::WORKING){
            throw new Exception('This request is not approved yet!', RpcErrors::CRUD_ERROR_CODE);
        }
        $result = new PolicyRequestDataObject($item->toArray());
        $result->items = $this->itemsToDataObjects($item->items);
        $result->sender = $item->sender;
        $result->receiver = $item->receiver;
        $result->requested_user = $item->requester;
        $result->approved_user = $item->approver;
        return $result;
    }

    /**
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return \App\DataObjects\DataObjectPagination
     */
    public function paginate(int $page = 1, int $limit = 25, ?iterable $filters = null): DataObjectPagination {
        $closure = function ($item) {
            $result = new PolicyRequestDataObject($item->toArray());
            $result->items = $this->itemsToDataObjects($item->items);
            $result->sender = $item->sender;
            $result->receiver = $item->receiver;
            $result->requested_user = $item->requester;
            $result->approved_user = $item->approver;
            return $result;
        };
        return $this->filterAndPaginate(
            PolicyRequest::query()
                ->where('is_deleted','=', false)
                ->where(function ($query) {
                    $query->where('sender_id', Auth::user()->profile->organization_id)
                        ->orWhere('receiver_id', Auth::user()->profile->organization_id);
                }),
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
     * @return \App\DataObjects\DataObjectPagination
     * @throws \Exception
     */
    public function paginateSent(int $page = 1, int $limit = 25, ?iterable $filters = null): DataObjectPagination {
        if (Auth::user()->profile->organization->organization_type_id == Organization::COMPANY){
            throw new Exception("Company can't send requests");
        }
        $closure = function ($item) {
            $result = new PolicyRequestDataObject($item->toArray());
            $result->items = $this->itemsToDataObjects($item->items);
            $result->sender = $item->sender;
            $result->receiver = $item->receiver;
            $result->requested_user = $item->requester;
            $result->approved_user = $item->approver;
            return $result;
        };
        return $this->filterAndPaginate(
            PolicyRequest::query()
                ->where('is_deleted','=', false)
                ->where(function ($query) {
                    $query->where('sender_id', Auth::user()->profile->organization_id);
                }),
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
     * @return \App\DataObjects\DataObjectPagination
     * @throws \Exception
     */
    public function paginateReceived(int $page = 1, int $limit = 25, ?iterable $filters = null): DataObjectPagination {
        if (Auth::user()->profile->organization->organization_type_id == Organization::AGENT
            || Auth::user()->profile->organization->organization_type_id == Organization::SUB_AGENT){
            throw new Exception("Agents can't receive requests");
        }
        $closure = function ($item) {
            $result = new PolicyRequestDataObject($item->toArray());
            $result->items = $this->itemsToDataObjects($item->items);
            $result->sender = $item->sender;
            $result->receiver = $item->receiver;
            $result->requested_user = $item->requester;
            $result->approved_user = $item->approver;
            return $result;
        };
        return $this->filterAndPaginate(
            PolicyRequest::query()
                ->where('is_deleted','=', false)
                ->where(function ($query) {
                    $query->where('receiver_id', Auth::user()->profile->organization_id);
                }),
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
     * @return \App\DataObjects\DataObjectPagination
     * @throws \Exception
     */
    public function paginateAxo(int $page = 1, int $limit = 25, ?iterable $filters = null): DataObjectPagination {
//        if (Auth::user()->profile->organization->organization_type_id == Organization::AGENT
//            || Auth::user()->profile->organization->organization_type_id == Organization::SUB_AGENT){
//            throw new Exception("Axo can't receive requests");
//        }
        $closure = function ($item) {
            $result = new PolicyRequestDataObject($item->toArray());
            $result->items = $this->itemsToDataObjects($item->items);
            $result->sender = $item->sender;
            $result->receiver = $item->receiver;
            $result->requested_user = $item->requester;
            $result->approved_user = $item->approver;
            return $result;
        };
        return $this->filterAndPaginate(
            PolicyRequest::query()
                ->where('is_deleted','=', false)
                ->where('status','=', PolicyRequest::WORKING)
                ->where(function ($query) {
                    $query->where('receiver_id', Auth::user()->profile->organization_id);
                }),
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
     * @return \App\DataObjects\DataObjectPagination
     */
    public function paginateApproved(int $page = 1, int $limit = 25, ?iterable $filters = null){
        $models = PolicyRequest::query()
            ->where('status','=', PolicyRequest::WORKING)
            ->where('is_deleted','=', false)
            ->latest()->paginate($limit);
        $items = $models->getCollection()->transform(function ($item){
            $result = new PolicyRequestDataObject($item->toArray());
            $result->items = $this->itemsToDataObjects($item->items);
            $result->sender = $item->sender;
            $result->receiver = $item->receiver;
            $result->requested_user = $item->requester;
            $result->approved_user = $item->approver;
            return $result;
        });
        return new DataObjectPagination($items, $models->total(), $limit, $page);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return CommonActionResult
     */
    public function setStatusViewed(Request $request){
        $item = PolicyRequest::query()->findOrFail($request->id);
        $item->update([
            'status' => PolicyRequest::VIEWED
        ]);
        return new CommonActionResult($item);
    }

    /**
     * @param PolicyRequestApproveActionData $action_data
     * @return CommonActionResult
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function approve(PolicyRequestApproveActionData $action_data)
    {
        try {
            $action_data->validate();
            DB::beginTransaction();
            $policy_request = PolicyRequest::query()->findOrFail($action_data->id);
            if ($policy_request->status == PolicyRequest::REJECTED){
                throw new Exception('Cannot change this request because of this request is already denied!');
            }
            if ($policy_request->status == PolicyRequest::COMPLETED){
                throw new Exception('Cannot change this request because of this request is already completed!');
            }
            $policy_request->update([
                'status' => PolicyRequest::WORKING
            ]);
            foreach ($action_data->items as $item){
                $approve_item = PolicyRequestItemApproveActionData::createFromArray($item);
                $approve_item->validate();
                if ($approve_item->amount < 1){
                    throw new Exception('Amount cannot be less than 1');
                }
                $request_item = PolicyRequestItem::query()->findOrFail($approve_item->id);
                if ($approve_item->amount > $request_item->amount){
                    throw new Exception('Amount cannot be more than requested amount!');
                }
                if ($request_item->policy_request_id = $policy_request->id){
                    $request_item->update([
                        'approved_amount' => $approve_item->amount
                    ]);
                }
            }
            DB::commit();
            return new CommonActionResult($policy_request->id);
        } catch (Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    /**
     * @param int $id
     * @return CommonActionResult
     * @throws \Throwable
     */
    public function approveAll(int $id)
    {
        try {
            DB::beginTransaction();
            $policy_request = PolicyRequest::query()->findOrFail($id);
            if ($policy_request->status == PolicyRequest::REJECTED){
                throw new Exception('Cannot change this request because of this request is already denied!');
            }
            if ($policy_request->status == PolicyRequest::COMPLETED){
                throw new Exception('Cannot change this request because of this request is already completed!');
            }
            $policy_request->update([
                'status' => PolicyRequest::WORKING
            ]);
            foreach ($policy_request->items as $item){
                $item->update([
                    'approved_amount' => $item->amount
                ]);
            }
            DB::commit();
            return new CommonActionResult($policy_request->id);
        } catch (Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    /**
     * @param $items
     * @return array
     */
    public function itemsToDataObjects($items){
        $result = [];
        foreach ($items as $item){
            $object = new PolicyRequestItemDataObject($item->toArray());
            $object->policy = $item->policy;
            $result[] = $object;
        }
        return $result;
    }
}
