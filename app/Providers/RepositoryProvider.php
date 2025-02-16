<?php

namespace App\Providers;

use App\Repositories\Base\EloquentRepository;
use App\Repositories\Base\RepositoryInterface;
use App\Repositories\AuthRepositoryInterface;
use App\Repositories\Eloquent\AuthRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RepositoryInterface::class, EloquentRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
