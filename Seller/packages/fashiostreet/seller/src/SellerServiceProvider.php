<?php
namespace fashiostreet\seller;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class SellerServiceProvider extends ServiceProvider
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
        $this->app->make('fashiostreet\seller\Tabs\TabsRepository');
        $this->app->make('fashiostreet\seller\Shops\ShopsRepository');
        $this->app->make('fashiostreet\seller\Response\ResponseController');
        $this->app->make('fashiostreet\seller\Orders\OrdersRepository');
        $this->app->make('fashiostreet\seller\Common\CommonController');
        //Response facade binding
        App::bind('FS_Response',function (){
            return new \fashiostreet\seller\Response\ResponseController;
        });

        //image facade binding
        App::bind('FS_Image',function (){
            return new \fashiostreet\seller\Image\ImageRepository;
        });
    }
}
