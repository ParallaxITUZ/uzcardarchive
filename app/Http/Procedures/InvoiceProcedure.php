<?php

namespace App\Http\Procedures;

use App\ActionData\Invoice\InvoiceActionData;
use App\Services\InvoiceService;
use App\Structures\JsonRpcResponse;
use App\Structures\RpcErrors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class InvoiceProcedure
{
    /**
     * @var InvoiceService
     */
    protected InvoiceService $service;

    /**
     * InvoiceProcedure constructor.
     * @param InvoiceService $service
     */
    public function __construct(InvoiceService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonRpcResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): JsonRpcResponse
    {
//        if (!Auth::user()->hasPermission('dictionaries_read')){
//            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
//        }
        $items = $this->service->paginate(request()->get('page', 1), request()->get('limit', 10), null);
        if (isset($items->error)){
            return JsonRpcResponse::error($items->error, $items->error_code);
        } else {
            return JsonRpcResponse::success($items);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonRpcResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws ValidationException
     */
    public function paid(Request $request): JsonRpcResponse
    {
//        if (!Auth::user()->hasPermission('centres_read')){
//            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
//        }
        $action_data = InvoiceActionData::createFromRequest($request);
        $item = $this->service->paid($action_data);
        if (isset($item->error)){
            return JsonRpcResponse::error($item->error, $item->error_code);
        } else {
            return JsonRpcResponse::success($item);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonRpcResponse
     */
//    public function cancel(Request $request): JsonRpcResponse
//    {
////        if (!Auth::user()->hasPermission('centres_read')){
////            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
////        }
//        $action_data = InvoiceIdAcionData::createFromRequest($request);
//        $item = $this->service->cancelPayment($action_data);
//        if (isset($item->error)){
//            return JsonRpcResponse::error($item->error, $item->error_code);
//        } else {
//            return JsonRpcResponse::success($item);
//        }
//    }
}
