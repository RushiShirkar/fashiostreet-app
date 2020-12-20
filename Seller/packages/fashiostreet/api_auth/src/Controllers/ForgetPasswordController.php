<?php
namespace fashiostreet\api_auth\Controllers;
use Illuminate\Http\Request;
use ResetPassword;
class ForgetPasswordController {


    public function forgetpassword(Request $request)
    {
        return ResetPassword::CreateResetPassword($request);
    }
    public function CompletedForgetPassword(Request $request)
    {
        return ResetPassword::CompleteResetPassword($request,$request->code);
    }
}
