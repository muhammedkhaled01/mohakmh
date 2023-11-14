<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

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
        Validator::extend(
            'filter',
            function ($attribute, $value, $params) {
                return !in_array(strtolower($value), $params);
            },
            'The value is prohipted!'
        );
        Validator::extend('phone_with_country_code', function ($attribute, $value, $parameters, $validator) {
            // Define the regular expression pattern for the phone number with a country code.
            $pattern = '/^\+\d{1,4}\d{8,15}$/';

            return preg_match($pattern, $value);
        });

        Paginator::useBootstrapFive();

        Schema::defaultStringLength(191);
    }
}
