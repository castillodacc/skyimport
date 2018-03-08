<?php

namespace skyimport\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Hash;
use Validator;

class ValidationsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('full_name', function($attribute, $value, $parameters)
        {
            if (str_contains($value, ' ')) {
                return true;
            }
            return false;
        }, 'El campo :attribute debe poseer nombre y apellido.');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
