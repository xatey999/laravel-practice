<?php

namespace App\Providers;

use App\Enums\UserRoleEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view): void {
            $user = Auth::user();
            $isAuthenticated = $user !== null;
            $isCustomer = $user?->role === UserRoleEnum::CUSTOMER;

            $view->with([
                'navCanShowCart' => $isAuthenticated && $isCustomer,
                'navCanShowOrders' => $isAuthenticated,
                'navOrdersLabel' => $isCustomer ? 'Orders' : 'Manage Orders',
            ]);
        });
    }
}
