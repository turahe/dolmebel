<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Contracts\BankRepositoryInterface::class,
            \App\Repositories\BankRepository::class
        );
        $this->app->bind(
            \App\Contracts\BlogRepositoryInterface::class,
            \App\Repositories\BlogRepository::class
        );
        $this->app->bind(
            \App\Contracts\BrandRepositoryInterface::class,
            \App\Repositories\BrandRepository::class
        );

        $this->app->bind(
            \App\Contracts\CalendarRepositoryInterface::class,
            \App\Repositories\CalendarRepository::class
        );

        $this->app->bind(
            \App\Contracts\DisputeRepositoryInterface::class,
            \App\Repositories\DisputeRepository::class
        );
        $this->app->bind(
            \App\Contracts\FaqRepositoryInterface::class,
            \App\Repositories\FaqRepository::class
        );
        $this->app->bind(
            \App\Contracts\InventoryRepositoryInterface::class,
            \App\Repositories\InventoryRepository::class
        );
        $this->app->bind(
            \App\Contracts\ManufactureRepositoryInterface::class,
            \App\Repositories\ManufactureRepository::class
        );
        $this->app->bind(
            \App\Contracts\MediaRepositoryInterface::class,
            \App\Repositories\MediaRepository::class
        );
        $this->app->bind(
            \App\Contracts\OrderRepositoryInterface::class,
            \App\Repositories\OrderRepository::class
        );

        $this->app->bind(
            \App\Contracts\PageRepositoryInterface::class,
            \App\Repositories\PageRepository::class
        );

        $this->app->bind(
            \App\Contracts\PipelineRepositoryInterface::class,
            \App\Repositories\PipelineRepository::class
        );
        $this->app->bind(
            \App\Contracts\ProductRepositoryInterface::class,
            \App\Repositories\ProductRepository::class
        );

        $this->app->bind(
            \App\Contracts\RefundRepositoryInterface::class,
            \App\Repositories\RefundRepository::class
        );
        $this->app->bind(
            \App\Contracts\RoleRepositoryInterface::class,
            \App\Repositories\RoleRepository::class
        );

        $this->app->bind(
            \App\Contracts\ShopRepositoryInterface::class,
            \App\Repositories\ShopRepository::class
        );
        $this->app->bind(
            \App\Contracts\SlideRepositoryInterface::class,
            \App\Repositories\SlideRepository::class
        );
        $this->app->bind(
            \App\Contracts\SupplierRepositoryInterface::class,
            \App\Repositories\SupplierRepository::class
        );

        $this->app->bind(
            \App\Contracts\TaxRepositoryInterface::class,
            \App\Repositories\TaxRepository::class
        );
        $this->app->bind(
            \App\Contracts\TicketRepositoryInterface::class,
            \App\Repositories\TicketRepository::class
        );
        $this->app->bind(
            \App\Contracts\UserRepositoryInterface::class,
            \App\Repositories\UserRepository::class
        );
        $this->app->bind(
            \App\Contracts\WarehouseRepositoryInterface::class,
            \App\Repositories\WarehouseRepository::class
        );

        $this->app->bind(
            \App\Contracts\Master\BankRepositoryInterface::class,
            \App\Repositories\Master\BankRepository::class
        );
        $this->app->bind(
            \App\Contracts\Master\CurrencyRepositoryInterface::class,
            \App\Repositories\Master\CurrencyRepository::class
        );
        $this->app->bind(
            \App\Contracts\Master\LanguageRepositoryInterface::class,
            \App\Repositories\Master\LanguageRepository::class
        );

        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //        JsonResource::withoutWrapping();

        Password::defaults(function () {
            return Password::min(8)
                ->mixedCase()
                ->uncompromised();
        });
    }
}
