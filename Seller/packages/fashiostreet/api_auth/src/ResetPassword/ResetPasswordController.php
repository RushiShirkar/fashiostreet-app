<?php
/**
 * Created by PhpStorm.
 * User: sagar
 * Date: 6/25/2018
 * Time: 11:19 PM
 */

namespace fashiostreet\api_auth\ResetPassword;

use App\Http\Controllers\Controller;
use fashiostreet\api_auth\Activation\ResetPasswordTraits;
use FS_Response;
use User;
use fashiostreet\api_auth\Controllers\SendSMS as SendSMS;

class ResetPasswordController extends Controller
{
    use ResetPasswordTraits;

    public function CreateResetPassword($user)
    {
        $mobile = $user->mobile;
        $msg = new SendSMS();
        $resetpassword= null;
        $user = User::findByCredential($user);
        if(($resetpassword = $this->exists($user)) != false)
        {
            //send directly sms for activation because activation already exists
            $msg->send($mobile,$resetpassword->code); 
            return $resetpassword;
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

    public function CompleteResetPassword($user,$code)
    {
        $tmp = $user->password;
        $user = User::findByCredential($user);
        $user->{'password'} = $tmp;
        unset($tmp);
        if(!$user)
        {
            return FS_Response::error(500,'Invalid user credentials');
        }
        if(($this->completed($user) != false)&& ($this->exists($user) == false))
        {
            return FS_Response::error(500,'invalid request url found from reset password or expire otp');
        }
        if($this->complete($user,$code))
        {
            return FS_Response::success('message','password successfully reset');
        }
        return FS_Response::error(500,'invalid otp found');
    }
}
