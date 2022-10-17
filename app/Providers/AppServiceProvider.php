<?php

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;
use App\Validator\CustomeValidator;

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
        //
        $this->app->validator->resolver(function($translator, $data, $rules, $messages) {
            return new CustomeValidator($translator, $data, $rules, $messages);
        });
    }
}
