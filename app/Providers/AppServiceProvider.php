<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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
        Validator::extend('confirmPassword', function($attribute, $value, $parameters, $validator) {
            if(Hash::check($value,Auth()->User()->password)){
                return true;
            }
            return false;
        });

        Validator::replacer('confirmPassword', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute',$attribute, 'Mật khẩu hiện tại không đúng');
        });
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
    }
}
