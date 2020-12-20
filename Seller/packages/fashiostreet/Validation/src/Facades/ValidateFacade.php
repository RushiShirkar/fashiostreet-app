<?php
namespace fashiostreet\Validation\Facades;

use Illuminate\Support\Facades\Facade;

class ValidateFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Validate';
    }
}
