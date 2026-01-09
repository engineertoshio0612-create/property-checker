<?php

namespace App\Providers;

use App\Queries\EloquentPropertyQuery;
use App\Queries\PropertyQueryInterface;
use App\Services\PropertyService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PropertyService::class);
        $this->app->bind(PropertyQueryInterface::class, EloquentPropertyQuery::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
