<?php

namespace App\Exceptions;

use App\Structures\JsonRpcResponse;
use App\Structures\RpcErrors;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Exceptions\ModelNotFoundException as ModelNotFoundExceptionOur;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($request->wantsJson()) {
            $type = get_class($e);
            if ($e instanceof AuthenticationException){
                return response()->json(
                    JsonRpcResponse::error(
                        'You are not authorized!',
                        JsonRpcException::UNAUTHENTICATED,
                        $type,
                        $e->getMessage()
                    )
                );
            }

            if ($e instanceof ValidationException){
                return response()->json(
                    JsonRpcResponse::error(
                        'Validation error!',
                        RpcErrors::CRUD_ERROR_CODE,
                        $type,
                        $e->getMessage(),
                        $e->errors()
                    )
                );
            }

            if ($e instanceof QueryException){
                return response()->json(
                    JsonRpcResponse::error(
                        'Database query exception!',
                        RpcErrors::CRUD_ERROR_CODE,
                        $type,
                        $e->getMessage()
                    )
                );
            }

            if ($e instanceof ModelNotFoundException) {
                return response()->json(
                    JsonRpcResponse::error(
                        'There is no result for parameters: '.implode(', ', $e->getIds()).'!',
                        RpcErrors::CRUD_ERROR_CODE,
                        $type,
                        $e->getMessage(),
                        [
                            'model' => $e->getModel(),
                            'ids' => $e->getIds()
                        ]
                    )
                );
            }

            if ($e instanceof ModelNotFoundExceptionOur) {
                return response()->json(
                    JsonRpcResponse::error(
                        'Model not found Exception!',
                        RpcErrors::CRUD_ERROR_CODE,
                        $type,
                        $e->getMessage()
//                        $e->getTrace()
                    )
                );
            }

            if (is_subclass_of($e, JsonRpcException::class) || $e instanceof JsonRpcException) {
                return response()->json(
                    JsonRpcResponse::error(
                        'Invalid JSON-RPC!',
                        JsonRpcException::INVALID_JSON_RPC,
                        $type,
                        $e->getMessage()
                    )
                );
            }

            if ($e instanceof Exception){
                return response()->json(
                    JsonRpcResponse::error(
                        'Unhandled error!',
                        JsonRpcException::INVALID_JSON_RPC,
                        $type,
                        $e->getMessage(),
                        $e->getTrace()
                    )
                );
            }
        }

        return parent::render($request, $e);
    }
}
