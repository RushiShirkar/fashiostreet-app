<?php
namespace fashiostreet\api_auth\Exceptions;

use Exception;
use FS_Response;

class ActivationException extends Exception
{
    //Tabs Exception
    public function render($request)
    {
        return FS_Response::error(401,$this->getMessage());
    }
}
