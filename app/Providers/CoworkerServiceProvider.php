<?php

namespace App\Providers;

use App\Repository\CoworkerRepository;
use Illuminate\Support\ServiceProvider;
use App\Repository\Eloquent\CoworkerRepository as EloquentCoworkerRepository;

class CoworkerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            CoworkerRepository::class,
            EloquentCoworkerRepository::class
        );

        $this->app->singleton('coworker', CoworkerRepository::class);
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
