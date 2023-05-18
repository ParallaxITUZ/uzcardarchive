<?php
namespace App\Http\Procedures;

use App\ActionData\Dictionary\DictionaryActionData;
use App\ActionData\Dictionary\DictionaryUpdateActionData;
use App\Filters\BaseFilter;
use App\Filters\BaseLangFilter;
use App\Services\DictionaryService;
use App\Structures\RpcErrors;
use Exception;
use Illuminate\Http\Request;
use App\Structures\JsonRpcResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class DictionaryProcedure {
    /**
     * @var DictionaryService
     */
    protected $service;

    /**
     * DictionaryProcedure constructor.
     * @param DictionaryService $service
     */
    public function __construct(DictionaryService $service)
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
        if (!Auth::user()->hasPermission('dictionaries_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $filters = new Collection();

        $filters->push(
            BaseFilter::get(request('name'), 'name'),
            BaseLangFilter::get(request('display_name'), 'display_name'),
        );

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
     */
    public function store(Request $request): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('dictionaries_create')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $action_data = DictionaryActionData::createFromRequest($request);
        $item = $this->service->create($action_data);
        return JsonRpcResponse::success($item);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonRpcResponse
     * @throws \Exception
     */
    public function show(Request $request): JsonRpcResponse
    {
        if ($request->get('id')){
            $item = $this->service->showById($request->get('id'));
        } elseif ($request->get('name')){
            $item = $this->service->showByName($request->get('name'));
        } else {
            throw new Exception('You have to send at least on of the name or id.');
        }
        return JsonRpcResponse::success($item);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonRpcResponse
     * @throws \Exception
     */
    public function conf(Request $request): JsonRpcResponse
    {
        if ($request->get('name')){
            $item = $this->service->conf($request->get('name'));
        } else {
            throw new Exception('You have to send the name of dictionary.');
        }
        return JsonRpcResponse::success($item);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonRpcResponse
     * @throws \Exception
     */
    public function get(Request $request): JsonRpcResponse
    {
        if ($request->get('id')){
            $item = $this->service->getById($request->get('id'));
        } elseif ($request->get('name')){
            $item = $this->service->getByName($request->get('name'));
        } else {
            throw new Exception('You have to send at least on of the name or id.');
        }
        return JsonRpcResponse::success($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonRpcResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        if (!Auth::user()->hasPermission('dictionaries_update')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $action_data = DictionaryUpdateActionData::createFromRequest($request);
        return JsonRpcResponse::success($this->service->update($action_data));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonRpcResponse
     */
    public function destroy(Request $request)
    {
        if (!Auth::user()->hasPermission('dictionaries_delete')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        return JsonRpcResponse::success($this->service->delete($request->get('id')));
    }
}
