<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\Eloquent\TypeRepository as EloquentTypeRepository;
use App\Repository\TypeRepository;

class TypeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            TypeRepository::class,
            EloquentTypeRepository::class
        );

        $this->app->singleton('type', TypeRepository::class);
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
