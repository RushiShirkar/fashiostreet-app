<?php

namespace fashiostreet\seller\Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResponseController extends Controller
{
    /*
     * Global Success Response Method
     * */
    public function success($type,$data)
    {
        return response()->json([
            'type' => $type,
            'result' => $data
        ],200);
    }

    /*
     * Global Error Response Method
     * */
    public function error($status,$message)
    {
        return response()->json([
            'status' => $status,
            'message' => $message
        ],500);
    }

}
