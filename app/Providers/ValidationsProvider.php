<?php

namespace skyimport\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Hash;
use Validator;
use Auth;

class ValidationsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * validacion para agregar nombre y apellido.
         */
        Validator::extend('full_name', function($attribute, $value, $parameters)
        {
            if (str_contains($value, ' ')) {
                return true;
            }
            return false;
        }, 'El campo :attribute debe poseer nombre y apellido.');

        /**
         * validacion por expresion regular de una cedula de identidad.
         * de 6 a 8 caracteres
         * y solo numeros del 0 al 9
         */
        Validator::extend('exr_ced', function($attribute, $value)
        {
            if ($value[0] == '0') return false;
            return preg_match('/^([0-9]{7,13})$/', $value);
        }, 'El campo :attribute es incorrecto');

        /**
         * Verifica si existe el email que se registrara en una lista blanca.
         */
        Validator::extend('ValidEmailDomain', function($attribute, $value)
        {
            return true;
        //     if (str_contains($value, '@')) {
        //         $domain = explode('@', $value)[1];
        //         $domains = [
        //             'gmail.com', 'hotmail.com', 'outlook.com',
        //             'yahoo.com', 'mail.com',
        //         ];
        //         return in_array($domain, $domains);
        //     }
        }, 'El dominio de tu email no es permitido.');

        /**
         * Comprueba que sea la contraseña actual del usuario autentificado.
         */
        Validator::extend('current_password', function($attribute, $value)
        {
            return Hash::check($value, Auth::user()->password);
        }, 'El campo :attribute no coincide con su contraseña actual.');

        /**
         * Verifiva el campo solo tenga letras y espacios.
         */
        Validator::extend('alfa_space', function($attribute, $value)
        {
            if ($value[0] == '') return false;
            return preg_match('/.([a-zA-Z])$/', $value);
            return false;
        }, 'No debe poseer caracteres especiales ni números.');

        /**
         * Verifiva que el valor a ingrasar solo este 1 vez en la bd.
         */
        Validator::extend('unique1', function($attribute, $value, $parameters)
        {
            $match = \DB::table($parameters[0])->where($attribute, '=', $value)->count();
            if ($match > 1) {
                return false;
            }
            return true;
        }, 'El elemento :attribute ya está en uso.');
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
