<?php

namespace App\Providers;

use App\Contracts\SmsGatewayContract;
use App\Http\Controllers\Api\RPCProxyV1Controller;
use App\Services\SmsService;
use App\SmsGateways\PlayMobile\PlaymobileGateway;
use App\Structures\RpcBinder;
use App\Structures\RpcProcedures;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RpcProcedures::class, function () {
            return new RpcProcedures();
        });

        $this->app->singleton(RpcBinder::class, function ($container) {
            return new RpcBinder($container);
        });

        $this->app->singleton(SmsGatewayContract::class, function () {
            return new SmsService(new PlaymobileGateway());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::macro('rpcEndpoint', function (string $uri, $callback) {
            app(RpcProcedures::class)->setEndpoint($uri);
            call_user_func($callback);

            return Route::post($uri, RPCProxyV1Controller::class)
                ->setDefaults([
                    'procedures' => app(RpcProcedures::class)->getProcedures()
                ]);
        });

        Route::macro('rpc', function (string $method, string $procedure) {
            $procedure = "\\App\\Http\\Procedures\\$procedure";
            app(RpcProcedures::class)->addProcedure($method, $procedure);
        });
    }
}
