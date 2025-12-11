<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\RestaurantRepositoryInterface;
use App\Interfaces\RestaurantServiceInterface;
use App\Repositories\RestaurantRepository;
use App\Services\RestaurantService;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind the repository interface to its implementation
        $this->app->bind(
            RestaurantRepositoryInterface::class,
            RestaurantRepository::class
        );

        // Bind the service interface to its implementation
        $this->app->bind(
            RestaurantServiceInterface::class,
            RestaurantService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
