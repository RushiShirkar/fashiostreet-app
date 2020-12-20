<?php

namespace fashiostreet\api_auth\Controllers;

use Activation;
use fashiostreet\api_auth\Exceptions\SystemException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FS_Response;
use Illuminate\Support\Facades\DB;
use Validate;
use fashiostreet\api_auth\Exceptions\ErrorException;
use Illuminate\Support\Facades\Hash;
use fashiostreet\api_auth\Controllers\UserModel as UserModel;

class RegisterController extends Controller
{
    protected $request;

    function __construct(Request $request)
    {
        $request = (object)$request->only(['mobile','password','code']);
        $this->request = $request;
    }

    public function Register(Request $request)
    {
        DB::beginTransaction();
        $this->CredentialsValidate();
        $this->CheckUserExistsorNot();
        $user = $this->createUser($request);
        Activation::CreateActivation($user);
        //send sms function is left
        DB::commit();
        return FS_Response::success('message','Successfully users account created');
    }

    public function CompleteRegistration()
    {
        return Activation::CompleteActivation($this->request,$this->request->code);
    }


    protected function CredentialsValidate()
    {
        if(!Validate::numericOnly($this->request->mobile,true,0,10)) {
            throw new ErrorException('Invalid mobile number found');
        }
    }

    public function hashPassword()
    {
        return Hash::make($this->request->password);
    }

    protected function createUser()
    {
        try{
            $user = new UserModel();
            $user->mobile = $this->request->mobile;
            $user->password = $this->hashPassword();
            $user->save();
            return $user;
        }
        catch (QueryException $e)
        {
            throw new SystemException('failed to create user try again or contact to our customer service');
        }
    }

    protected function CheckUserExistsorNot()
    {
        $user = (array) DB::select('select id from users where mobile = ? limit 1',[$this->request->mobile]);

        if(count($user) > 0)
        {
            throw new ErrorException('user already exists');
        }
        return $user;

    }

}
