<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\User\V1\UserRepository;
use App\Interfaces\Repository\UserRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $version = config('app.version');
        $this->app->bind(
            UserRepositoryInterface::class,
            app('App\Repositories\User\V' . $version . '\UserRepository')::class
        );
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
