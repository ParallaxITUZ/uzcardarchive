<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\JsonRpcException;
use App\Structures\RpcBinder;
use Illuminate\Http\Request;
use App\Structures\RpcProcedures;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Routing\SortedMiddleware;
use App\Http\Requests\RpcCompatibleRequest;
use Illuminate\Routing\ControllerDispatcher;
use Illuminate\Routing\MiddlewareNameResolver;

class RPCProxyV1Controller extends Controller
{
    /**
     * @param \App\Http\Requests\RpcCompatibleRequest $request
     * @param $procedures
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\JsonRpcException
     */
    public function __invoke(RpcCompatibleRequest $request, $procedures): JsonResponse
    {
        $validation = $request->validated();

        app()->setLocale($request->header('Accept-Language'));

        $method = $validation->get('method');
        $id = $validation->get('id');
        $params = $validation->get('params', []);

        $binder = app(RpcBinder::class);

        $procedures = app(RpcProcedures::class);

        $uri = basename(request()->getUri());
        app(RpcProcedures::class)->setEndpoint($uri);

        $procedure = $procedures->findProcedure($method);

        if (empty($procedure)) {
            throw new JsonRpcException("Procedure not found.", JsonRpcException::PROCEDURE_NOT_FOUND, request("id"));
        }

        foreach ($request->keys() as $key) {
            $request->offsetUnset($key);
        }

        $request->merge($params);
        $request->merge(['__id' => $id]);

        return response()->json(app()->call($procedure, $binder->bindResolve($params)));
    }

    protected function gatherControllerMiddleware($controller, $method)
    {
        return collect($this->controllerMiddleware($controller, $method))->map(function ($name) {
            return (array)MiddlewareNameResolver::resolve($name, app('router')->getMiddleware(), app('router')->getMiddlewareGroups());
        })->flatten();
    }

    protected function controllerMiddleware($controller, $method)
    {
        return (new ControllerDispatcher(app()))->getMiddleware(
            $controller, $method
        );
    }

    protected function sortMiddleware($middleware)
    {
        return (new SortedMiddleware(app('router')->middlewarePriority, $middleware))->all();
    }
}
