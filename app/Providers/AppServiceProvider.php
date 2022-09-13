<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use App\Models\Faq;
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
        if ($this->app->isLocal()) {
        } else {
            $this->app['request']->server->set('HTTPS', true);
        }

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

        Validator::extend('check_unique', function($attribute, $value, $parameters, $validator) {
            $type = $parameters[0];
            $editId = $parameters[1];
            $orderNumber = $parameters[2];
            if($type){
                if($editId){
                    $faq = Faq::where('type',$type)->where('order_number',$orderNumber)->first();
                    if($faq->id==$editId){
                        return true;
                    }
                    else {
                        return false;
                    }
                }
                else {
                    $faq = Faq::where('type',$type)->where('order_number',$orderNumber)->first();
                    if($faq){
                        return false;
                    }
                    else {
                        return true;
                    }
                }
            }
            return true;
        });

        Validator::replacer('check_unique', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute',$attribute, 'Số thứ tự đã tồn tại ở loại câu hỏi này');
        });

    }
}
