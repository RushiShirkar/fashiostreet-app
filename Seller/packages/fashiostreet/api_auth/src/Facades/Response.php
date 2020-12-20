<?php
namespace fashiostreet\api_auth\Facades;

use Illuminate\Support\Facades\Facade;

class Response extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'FS_Response';
    }
}
