<?php

namespace App\Providers;

use App\Repositories\MovieRepository;
use App\Repositories\MovieRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
{
    $this->app->bind(
        MovieRepository::class,
        MovieRepositoryEloquent::class
    );
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
