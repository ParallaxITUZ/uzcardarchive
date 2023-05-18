<?php

namespace App\Http\Procedures;

use App\ActionData\User\UserActionData;
use App\ActionData\User\UserUpdateActionData;
use App\Filters\BaseFilter;
use App\Requests\Api\Auth\IdRequest;
use App\Services\UserService;
use App\Structures\JsonRpcResponse;
use App\Structures\RpcErrors;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UserProcedure
{
    /**
     * @var UserService
     */
    protected $service;

    /**
     * UserProcedure constructor.
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonRpcResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index(): JsonRpcResponse
    {
//        if (!Auth::user()->hasPermission('users_read')){
//            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
//        }

        $filters = new Collection();
//        $filters->push(
//            BaseFilter::get(request('name'), 'name'),
//        );
        $items = $this->service->paginate(
            request()->get('page', 1),
            request()->get('limit', 10),
            $filters
        );
        return JsonRpcResponse::success($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonRpcResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function store(Request $request): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('users_create')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $action_data = UserActionData::createFromRequest($request);
        return JsonRpcResponse::success($this->service->create($action_data));
    }

    /**
     * Display the specified resource.
     *
     * @param IdRequest $request
     * @return JsonRpcResponse
     */
    public function show(IdRequest $request): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('users_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        return JsonRpcResponse::success($this->service->get($request->get('id')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonRpcResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function update(Request $request)
    {
        if (!Auth::user()->hasPermission('users_update')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $action_data = UserUpdateActionData::createFromRequest($request);
        return JsonRpcResponse::success($this->service->update($action_data));
    }

    /**
     * Activate the specified resource from storage.
     *
     * @param IdRequest $request
     * @return JsonRpcResponse
     * @throws \Throwable
     */
    public function activate(IdRequest $request)
    {
        if (!Auth::user()->hasPermission('users_update')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        return JsonRpcResponse::success($this->service->activate($request->get('id')));
    }

    /**
     * Deactivate the specified resource from storage.
     *
     * @param IdRequest $request
     * @return JsonRpcResponse
     * @throws \Throwable
     */
    public function deactivate(IdRequest $request)
    {
        if (!Auth::user()->hasPermission('users_update')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        return JsonRpcResponse::success($this->service->deactivate($request->get('id')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param IdRequest $request
     * @return JsonRpcResponse
     * @throws \Throwable
     */
    public function destroy(IdRequest $request)
    {
        if (!Auth::user()->hasPermission('users_delete')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        return JsonRpcResponse::success($this->service->delete($request->get('id')));
    }
}
