<?php
namespace fashiostreet\api_auth\Facades;

use Illuminate\Support\Facades\Facade;

class Activation extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Activation';
    }
}
