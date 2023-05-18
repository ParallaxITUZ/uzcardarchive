<?php

namespace App\Providers;

use App\Filters\FilterAdapter;
use App\Filters\FilterInterface;
use Illuminate\Support\ServiceProvider;

class FilterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FilterInterface::class, FilterAdapter::class);

        /*
        // Example of registering persistent filter adapter for a concrete class

        $this->app->when('ConcreteClass')
            ->needs(FilterInterface::class)
            ->give(function () {
                $adapter = new FilterAdapter();

                $adapter->addPipes([
                    NameFilter::class,
                    PaginationFilter::class,
                    ProductIdFilter::class
                ]);

                return $adapter;
            });
        */
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
