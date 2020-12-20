<?php
namespace fashiostreet\throttle\Facades;

use Illuminate\Support\Facades\Facade;

class ThrottleFacades extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Throttle';
    }
}
