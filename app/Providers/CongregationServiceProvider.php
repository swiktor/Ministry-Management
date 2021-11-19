<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\Eloquent\CongregationRepository as EloquentCongregationRepository;
use App\Repository\CongregationRepository;

class CongregationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            CongregationRepository::class,
            EloquentCongregationRepository::class
        );

        $this->app->singleton('congregation', CongregationRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
