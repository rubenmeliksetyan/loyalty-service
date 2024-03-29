<?php

namespace App\Providers;

use App\Interfaces\Services\IAccountService;
use App\Interfaces\Services\ILoyaltyPointsService;
use App\Interfaces\Services\IUserService;
use App\Services\AccountService;
use App\Services\LoyaltyPointsService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IAccountService::class, AccountService::class);
        $this->app->bind(ILoyaltyPointsService::class, LoyaltyPointsService::class);
        $this->app->bind(IUserService::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
