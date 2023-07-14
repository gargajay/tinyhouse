<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('geography', 'string');
        \DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('geometry', 'string');
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        $this->CustomValidateRule();
    }



    // create custom validation rule
    public function CustomValidateRule()
    {
        // convert value in lower case and then check in database
        Validator::extend('iunique', function ($attribute, $value, $parameters, $validator) {
            $query = DB::table($parameters[0]);
            $query->where($parameters[1], "ILIKE", $value);
            $i = 2;
            while (isset($parameters[$i + 1])) {
                if (count(explode('~', $parameters[$i + 1])) > 1) {
                    $query->whereIn($parameters[$i], explode('~', $parameters[$i + 1]));
                } else {
                    $query->where($parameters[$i], "ILIKE", $parameters[$i + 1]);
                }
                $i += 2;
            }
            return !$query->count();
        }, 'The :attribute has already been taken.');


        // convert value in lower case and then check in database
        Validator::extend('iexists', function ($attribute, $value, $parameters, $validator) {
            $query = DB::table($parameters[0]);
            $query->where($parameters[1], "ILIKE", $value);
            $i = 2;
            while (isset($parameters[$i + 1])) {
                if (count(explode('~', $parameters[$i + 1])) > 1) {
                    $query->whereIn($parameters[$i], explode('~', $parameters[$i + 1]));
                } else {
                    $query->where($parameters[$i], "ILIKE", $parameters[$i + 1]);
                }
                $i += 2;
            }
            return $query->count() ? true : false;
        }, 'This :attribute is not exist.');


        // Create a new validation rule to check for a number with commas
        Validator::extend('comma_separated_number', function ($attribute, $value, $parameters, $validator) {
            return is_numeric(str_replace(',', '', $value));
        }, 'The :attribute must be a number with commas (e.g. 23,47,85)');

        // Create a new validation rule to check for positive integer number
        Validator::extend('positive_integer', function ($attribute,$value, $parameters, $validator) {
            return (intval($value) == $value && $value >= 0);
        }, 'The :attribute must be a number not float and negitive number.');

        // Create a new validation rule to check positive decimal number
        Validator::extend('positive_decimal', function ($attribute, $value, $parameters, $validator) {
            return (is_numeric($value) && $value >= 0);
        }, 'The :attribute must be a positive number.');

        // Create a new validation rule to check latitude
        Validator::extend('latitude', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(\+|-)?(?:90(?:(?:\.0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,6})?))$/', $value);
        }, 'The :attribute is not valid.');

        // Create a new validation rule to check longitude
        Validator::extend('longitude', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(\+|-)?(?:180(?:(?:\.0{1,6})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,6})?))$/', $value);
        }, 'The :attribute is not valid.');

    }
}
