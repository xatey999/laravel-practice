<?php

namespace App\Providers;

use App\Enums\UserRoleEnum;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
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
        $this->registerRateLimiters();

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

    private function registerRateLimiters(): void
    {
        RateLimiter::for('auth-login', function (Request $request) {
            $email = (string) $request->input('email', '');
            $ip = (string) $request->ip();

            return Limit::perMinute(5)->by(strtolower($email).'|'.$ip);
        });

        RateLimiter::for('auth-register', fn (Request $request) => [
            Limit::perMinute(3)->by((string) $request->ip()),
        ]);

        RateLimiter::for('cart-mutations', function (Request $request) {
            $userKey = (string) ($request->user()?->id ?? 'guest');
            $ip = (string) $request->ip();

            return Limit::perMinute(30)->by($userKey.'|'.$ip);
        });

        RateLimiter::for('orders-read', function (Request $request) {
            $userKey = (string) ($request->user()?->id ?? 'guest');
            $ip = (string) $request->ip();

            return Limit::perMinute(60)->by($userKey.'|'.$ip);
        });

        RateLimiter::for('checkout', function (Request $request) {
            $userKey = (string) ($request->user()?->id ?? 'guest');
            $ip = (string) $request->ip();

            return Limit::perMinute(6)->by($userKey.'|'.$ip);
        });
    }
}
