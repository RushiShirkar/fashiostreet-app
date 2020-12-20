<?php
namespace fashiostreet\seller\Shops;
use fashiostreet\seller\Exceptions\ErrorException;
use fashiostreet\seller\Shops\ShopsTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use FS_Image;
use FS_Response;
use Illuminate\Support\Facades\DB;

class ShopsRepository extends Controller{
    use ShopsTrait;

    protected $user;

    protected $shopField;

    function __construct(Request $request)
    {
        $this->user = array('id' => $request->header('userId'));
        $this->shopField = array(
            'users_id',
            'city_id',
            'name',
            'image',
            'owner_name',
            'contact',
            'alternate_contact',
            'address',
            'opening_time',
            'closing_time',
            'payment_mode',
            'closed_day',
            'longitude',
            'latitude',
            'gst_number',
            'pan_number'
        );
    }
    public function addOffer(Request $request)
    {
       $result = DB::table('shop')->where('id',$request->id)->update(['offers' => $request->offers]);
       return $result;
    }
    public function getShopOffers(Request $request,$id)
    {
	$offers = (array)DB::select('select offers from shop where id = ?',[$id]);
	return FS_Response::success('data',$offers);
    }
    public function AddShop(Request $request)
    {
        $this->CheckShopExistorNot();
        $image_name = 'asdasd';
        //$image_name = FS_Image::CreateImageName($request->extension,$request->image_name);
        $request->city = $this->getCity_id($request->city);
        DB::beginTransaction();
        $response = $this->create($request,$image_name);
        //FS_Image::uploadShopImage($request);
        DB::commit();
        return $response;
    }

    public function CheckShopExistorNot()
    {
        $shop = (array) DB::select('select id from shop where users_id = ? limit 1',[$this->user['id']]);
        if(count($shop) <= 0)
        {
            return false;
        }
        throw new ErrorException('Shop already exist, one user can create only one shop');
    }

    public function UpdateShop(Request $request)
    {
        $data = $request->only($this->shopField);
        if(isset($request->city))
        {
            $data->{'city_id'} = $this->getCity_id($request->city);
            unset($request->city);
        }
        DB::beginTransaction();
        $response = $this->update($data);
        if(isset($request->file) && isset($request->image_name) && isset($request->extension))
        {
            FS_Image::uploadShopImage($request,$request->image_name);
            unset($request->file);
            unset($request->extension);
            unset($request->image_name);
        }
        DB::commit();
        return $response;
    }

}
