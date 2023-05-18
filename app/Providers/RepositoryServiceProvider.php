<?php

namespace App\Providers;

use App\Models\ClientContract;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\ProductInsuranceClass;
use App\Models\ProductPeriod;
use App\Models\ProductTariff;
use App\Repositories\ClientContractRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\ProductInsuranceClassRepository;
use App\Repositories\ProductPeriodRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductTariffRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @var array|string[]
     */
    protected array $repositories = [
        ProductRepository::class => Product::class,
        ClientContractRepository::class => ClientContract::class,
        InvoiceRepository::class => Invoice::class,
        ProductPeriodRepository::class => ProductPeriod::class,
        ProductInsuranceClassRepository::class => ProductInsuranceClass::class,
        ProductTariffRepository::class => ProductTariff::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepositories();
    }

    /**
     * Registers only repositories
     */
    private function registerRepositories()
    {
        foreach ($this->repositories as $concrete => $implementation) {
            $this->app->when($concrete)
                ->needs(Builder::class)
                ->give(function () use ($implementation) {
                    return $implementation::query();
                });
        }
    }
}
