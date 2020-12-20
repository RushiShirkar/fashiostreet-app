<?php
namespace fashiostreet\Validation;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class ValidateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('Validate',function (){
            return new \fashiostreet\Validation\BasicValidation;
        });
    }
}
