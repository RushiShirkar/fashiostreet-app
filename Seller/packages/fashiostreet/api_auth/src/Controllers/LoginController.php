<?php

namespace fashiostreet\api_auth\Controllers;

use fashiostreet\api_auth\Layers\LayersChecker;
use fashiostreet\api_auth\Exceptions\ErrorException;
use fashiostreet\api_auth\Controllers\UserModel as UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FS_Response;
use Illuminate\Support\Facades\DB;
use Validate;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    protected $request;
    protected $layerChecker;

    function __construct(Request $request)
    {
        $request = (object)$request->only(['mobile','password']);
        $this->request = $request;
        $this->layerChecker = new LayersChecker();
    }
    public function hash1()
    {
        return Hash::make($this->request->password);
    }

    protected function CredentialsValidate()
    {
        if(!Validate::numericOnly($this->request->mobile,true,0,10)) {
            throw new ErrorException('Invalid mobile number found');
        }
    }
    protected function CreateToken($user)
    {
        return encrypt($user);
    }

    public function login()
    {
        $this->CredentialsValidate();
        $user = $this->findBycredentials();
        $this->layerChecker->Logincheck($user);
        $token = $this->CreateToken($user->id);
        if(empty($user->shop_id) || $user->shop_id == null || $user->shop_id == '')
        {
            $local_id = 0;
        }
        else{
            $local_id = $user->shop_id;
        }
        $refresh_token = $this->CreateToken($user->id);
        return FS_Response::success('data',array(
            'token' => $token,
            'shop_id' => $local_id,
            'userId' => $user->id,
            'refresh_token' => $refresh_token
        ));
    }

    protected function findBycredentials()
    {

        $user = DB::select('select users.id as id,users.password as password ,shop.id as shop_id from users left join shop on shop.users_id = users.id where users.mobile = ? limit 1',[$this->request->mobile]);

        if(count($user) <= 0)
        {
            throw new ErrorException('Invalid user found');
        }
        if(Hash::check($this->request->password,$user[0]->password) == 1)
        {
            return $user[0];
        }
        throw new ErrorException('Invalid mobile or password found');
    }
}
