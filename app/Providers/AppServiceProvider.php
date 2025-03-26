<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;

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
        Paginator::useBootstrapFive();

        Validator::extend('unique_username', function ($attribute, $value, $parameters, $validator) {
            return !\App\Models\User::where('name', $value)->exists();
        });

        Validator::replacer('unique_username', function ($message, $attribute, $rule, $parameters) {
            return 'Bu kullanıcı adı zaten alınmış.';
        });
    }
}
