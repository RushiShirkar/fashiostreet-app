<?php
namespace fashiostreet\throttle\Exceptions;

use Exception;
use FS_Response;

class ThrottleException extends Exception
{
    //Tabs Exception
    public function render($request)
    {
        return FS_Response::error(500,$this->getMessage());
    }
}
