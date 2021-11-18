<?php

namespace App\Providers;

use App\Repository\DashboardRepository;
use Illuminate\Support\ServiceProvider;
use App\Repository\Eloquent\DashboardRepository as EloquentDashboardRepository;

class DashboardServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            DashboardRepository::class,
            EloquentDashboardRepository::class
        );

        $this->app->singleton('dashboard', DashboardRepository::class);
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
