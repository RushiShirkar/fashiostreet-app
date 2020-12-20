<?php
namespace fashiostreet\throttle;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class ThrottleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('fashiostreet\throttle\Controllers\ThrottleController');
    }
}
