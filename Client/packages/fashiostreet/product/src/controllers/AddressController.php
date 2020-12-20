<?php
namespace fashiostreet\product;
use App\Http\Controllers\Controller;
use fashiostreet\product\address;
use fashiostreet\product\Auth\User;
use fashiostreet\product\Exceptions\ErrorException;
use Illuminate\Http\Request;
use FS_Response;

class AddressController extends Controller{
    protected $user_id;

    function __construct(Request $request)
    {
        $obj = new User();
        $this->user_id = $obj->getUserId($request);
    }

    public function getAddressById(Request $request)
    {
        $address = address::select(['id','address','first_name','last_name','area','mobile'])
            ->where('users_id',$this->user_id)
            ->where('id',$request->a_id)
            ->get();
        return $address;
    }

    public function getAddress($json = 'view')
    {
            $address = address::select(['id','address','first_name','last_name','area','mobile'])
                ->where('users_id',$this->user_id)
                ->get();
            if($json == 'json'){
                return FS_Response::success('message',$address);
            }
            else if($json == 'normal')
            {
                return $address;
            }
            if(\Request::route()->getName() == 'selectName')
            {
                return View('fashiostreet_client::orderAddress',['address' => $address]);
            }
            return View('fashiostreet_client::address',['address' => $address]);

    }
    public function addAddress(Request $request)
    {
        try{
            $address = new address();
            $address->address = $request->address;
            $address->first_name = $request->first_name;
            $address->last_name = $request->last_name;
            $address->area = $request->area;
            $address->mobile = $request->mobile;
            $address->users_id = $this->user_id;
            $address->save();
            return FS_Response::success('message','successfully new address added');
        }catch (\Illuminate\Database\QueryException $e)
        {
            throw new ErrorException('address,server error');
        }
    }
    public function editAddress(Request $request)
    {
        try {
            $address = address::where('id', $request->address_id)
                ->where('users_id', $this->user_id)
                ->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'area' => $request->area,
                    'address' => $request->address,
                    'mobile' => $request->mobile
                ]);
            if ($address <= 0 || $address == null || $address == false) {
                return FS_Response::error(500,'failed to update address');
            }
            return FS_Response::success('message','successfully address updated');
        }catch (\Illuminate\Database\QueryException $e)
        {
            throw new ErrorException('address,server error');
        }
    }
    public function deleteAddress(Request $request)
    {
        try{
            $address = address::where('users_id', $this->user_id)
                ->where('id', $request->address_id)
                ->delete();
            if ($address <= 0 || $address == null || $address == false) {
                return FS_Response::error(500,'failed to deleted address');
            }
            return FS_Response::success('message','successfully address deleted');
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            throw new ErrorException('address,server error');
        }
    }
    protected function withError($callback)
    {
        try
        {
            $callback();
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            return response()->json('Server error found '.$e->getCode(),500);
        }
    }
}