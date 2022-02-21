<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\Eloquent\GoalRepository as EloquentGoalRepository;
use App\Repository\GoalRepository;

class GoalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            GoalRepository::class,
            EloquentGoalRepository::class
        );

        $this->app->singleton('goal', GoalRepository::class);
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
