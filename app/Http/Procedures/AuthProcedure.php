<?php

namespace App\Http\Procedures;

use App\Services\AuthService;
use App\Structures\JsonRpcResponse;
use App\Requests\Api\Auth\LoginRequest;
use App\ActionData\Auth\AuthActionData;

class AuthProcedure
{
    /**
     * @var AuthService
     */
    protected $auth_service;

    /**
     * AuthProcedure constructor.
     * @param AuthService $auth_service
     */
    public function __construct(AuthService $auth_service)
    {
        $this->auth_service = $auth_service;
    }

    /**
     * @param LoginRequest $request
     * @return JsonRpcResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $request): JsonRpcResponse
    {
        $data = AuthActionData::createFromRequest($request);

        $action_result = $this->auth_service->login($data);

        if (!$action_result->success) {
            return JsonRpcResponse::error($action_result->error, $action_result->error_code);
        }
        return JsonRpcResponse::success(["token" => $action_result->token, "user" => $action_result->user]);
    }

    /**
     * @param LoginRequest $request
     * @return JsonRpcResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function loginWorker(LoginRequest $request): JsonRpcResponse
    {
        $data = AuthActionData::createFromRequest($request);

        $action_result = $this->auth_service->loginWorker($data);

        if (!$action_result->success) {
            return JsonRpcResponse::error($action_result->error, $action_result->error_code);
        }
        return JsonRpcResponse::success(["token" => $action_result->token, "user" => $action_result->user]);
    }

    /**
     * @return JsonRpcResponse
     */
    public function me(): JsonRpcResponse
    {
        $action_result = $this->auth_service->authUser();
        return JsonRpcResponse::success($action_result);
    }


    /**
     * @return JsonRpcResponse
     */
    public function logout(): JsonRpcResponse
    {
        $action_result = $this->auth_service->logout();
        if (!$action_result->success) {
            return JsonRpcResponse::error($action_result->error, $action_result->error_code);
        }
        return JsonRpcResponse::success();
    }


    /**
     * @return JsonRpcResponse
     */
    public function refresh(): JsonRpcResponse
    {
        $action_result = $this->auth_service->refreshToken();
        if (!$action_result->success) {
            return JsonRpcResponse::error($action_result->error, $action_result->error_code);
        }
        return JsonRpcResponse::success(["access_token" => $action_result->token]);
    }
}
