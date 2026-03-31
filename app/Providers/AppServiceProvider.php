<?php

namespace App\Providers;

use App\Enums\UserRoleEnum;
use App\Policies\ProductPolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Modules\Categories\Models\Product;

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
        Gate::policy(Product::class, ProductPolicy::class);

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
