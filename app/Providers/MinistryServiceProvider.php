<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\Eloquent\MinistryRepository as EloquentMinistryRepository;
use App\Repository\MinistryRepository;

class MinistryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            MinistryRepository::class,
            EloquentMinistryRepository::class
        );

        $this->app->singleton('ministry', MinistryRepository::class);
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
