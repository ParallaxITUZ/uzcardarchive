<?php

namespace App\Http\Procedures;

use App\ActionData\Attempt\AttemptActionData;
use App\ActionData\Attempt\AttemptUpdateActionData;
use App\Filters\BaseFilter;
use App\Requests\Api\Auth\PhoneRequest;
use App\Requests\Api\Auth\SmsRequest;
use App\Services\AttemptService;
use App\Services\SmsService;
use App\Structures\JsonRpcResponse;
use App\Structures\RpcErrors;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class AttemptProcedure
{
    /**
     * @var AttemptService
     */
    protected $service;
    protected $sms_service;

    /**
     * AttemptProcedure constructor.
     * @param AttemptService $service
     * @param \App\Services\SmsService $sms_service
     */
    public function __construct(AttemptService $service, SmsService $sms_service)
    {
        $this->service = $service;
        $this->sms_service = $sms_service;
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
        if (!Auth::user()->hasPermission('attempts_read')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $filters = new Collection();

        $filters->push(
            BaseFilter::get(request('step'), 'step'),
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
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function store(Request $request): JsonRpcResponse
    {
        if (!Auth::user()->hasPermission('attempts_create')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $action_data = AttemptActionData::createFromRequest($request);
        return JsonRpcResponse::success($this->service->create($action_data));
    }


    /**
     * @param \App\Requests\Api\Auth\SmsRequest $request
     * @return \App\Structures\JsonRpcResponse
     * @throws \App\Exceptions\SmsCodeException
     */
    public function checkMessage(SmsRequest $request){
        $response = $this->sms_service->check($request->get('phone'), $request->get('code'));
        return JsonRpcResponse::success($response);
    }

    /**
     * @param \App\Requests\Api\Auth\PhoneRequest $request
     * @return \App\Structures\JsonRpcResponse
     */
    public function sendMessage(PhoneRequest $request){
        $text = 'Если вы ознакомились и согласны с условиями публичный (ссылка на оферту),
        можете передать сотруднику следующий код:';
        $rand = rand(100000, 999999);
        $response = $this->sms_service->sendWithText($request->get('phone'), $text, $rand,'Attempt for Contract');
        return JsonRpcResponse::success($response);
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
        if (!Auth::user()->hasPermission('attempts_create')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $item = $this->service->get($request->get('id'));
        return JsonRpcResponse::success($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonRpcResponse
     * @throws \Illuminate\Validation\ValidationException|\Throwable
     */
    public function update(Request $request)
    {
        if (!Auth::user()->hasPermission('attempts_update')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $action_data = AttemptUpdateActionData::createFromRequest($request);
        $item =  $this->service->update($action_data);
        return JsonRpcResponse::success($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonRpcResponse
     */
    public function destroy(Request $request)
    {
        if (!Auth::user()->hasPermission('attempts_delete')){
            return JsonRpcResponse::error(RpcErrors::PERMISSION_DENIED_TEXT, RpcErrors::FORBIDDEN_CODE);
        }
        $item = $this->service->delete($request->get('id'));
        return JsonRpcResponse::success($item);
    }
}
