<?php

namespace fashiostreet\api_auth\Activation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use FS_Response;
use User;
use fashiostreet\api_auth\Activation\Activation;
use fashiostreet\api_auth\Activation\ActivationTraits;
use fashiostreet\api_auth\Controllers\SendSMS as SendSMS;

class ActivationController extends Controller
{
    use ActivationTraits;

    public function CreateActivation($user)
    {
        $mobile = $user->mobile;
        $msg = new SendSMS();
        $activation= null;
        if(($activation = $this->exists($user)) != false)
        {
            //send directly sms for activation because activation already exists
            $msg->send($mobile,$activation->code); 
            return $activation;
        }
        if($user = $this->create($user)) 
        {
            $msg->send($mobile,$user->code);
            return FS_Response::success('message', 'please verify user');
        }
        else
        {
            return FS_Response::error(500,'failed to create user');
        }

    }

    public function CompleteActivation($user,$code)
    {
        $user = User::findByCredential($user);
        if(!$user)
        {
            return FS_Response::error(500,'Invalid user credentials');
        }
        if(($this->completed($user) != false)&& ($this->exists($user) == false))
        {
            return FS_Response::error(500,'invalid request url found from activation or expire otp');
        }
        if($this->complete($user,$code))
        {
            return FS_Response::success('message','activation completed successfully');
        }
        return FS_Response::error(500,'invalid otp found');
    }


}
