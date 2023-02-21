<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Repository\UserRepositoryInterface;
use App\Interfaces\Repository\VillageRepositoryInterface;
use App\Interfaces\Repository\DistrictRepositoryInterface;
use App\Interfaces\Repository\FarmerRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $version = config('app.version');
        // $bindings = [
        //     UserRepositoryInterface::class  =>
        //     'App\Repositories\User\V' . $version . '\UserRepository',

        //     FarmerRepositoryInterface::class  =>
        //     'App\Repositories\Farmer\V' . $version . '\FarmerRepository',

        //     VillageRepositoryInterface::class  =>
        //     'App\Repositories\Village\V' . $version . '\VillageRepository',

        //     DistrictRepositoryInterface::class  =>
        //     'App\Repositories\District\V' . $version . '\DistrictRepository',
        // ];
        // foreach ($bindings as $key => $value) {
        //     $this->app->bind($key, app($value)::class);
        // }
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
