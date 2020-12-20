<?php
namespace fashiostreet\seller\Shops;
use fashiostreet\seller\Common\CommonRepository;
use fashiostreet\seller\Exceptions\SellerException;
use Illuminate\Support\Facades\DB;
use FS_Response;
trait ShopsTrait {
    use CommonRepository;
    public function create($shop, $image)
    {
        $user = $shop->header('userId');
        try
        {
            $shop = (array) DB::select(
                'CALL AddShop(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
                [
                    $user,
                    $shop->city,
                    $shop->name,
                    $image,
                    $shop->owner_name,
                    $shop->contact,
                    $shop->alternate_contact,
                    $shop->address,
                    $shop->opening_time,
                    $shop->closing_time,
                    $shop->payment_mode,
                    $shop->closed_day,
                    $shop->longitude,
                    $shop->latitude,
                    $shop->gst_number,
                    $shop->pan_number
                ]);
            if(count($shop) <= 0)
            {
                throw new SellerException('failed to create shop');
            }
            return FS_Response::success('data',array(
                'token'=>encrypt($shop[0]->id),
                'shop_id'=>$shop[0]->id
            ));
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            return $e->getMessage();
            throw new SellerException('Shop,server error try again or contact our customer service');
        }
    }

    public function update($shop_id,$data)
    {
        try
        {
            $updated_value = DB::table('shop')
                ->where('id',$shop_id)
                ->update($data);
            if($updated_value <= 0 || $updated_value == false || $updated_value == null)
            {
                throw new SellerException('failed to update shop data');
            }
            return FS_Response::success('successfully shop updated');
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            throw new SellerException('Shop,server error try again or contact our customer service');
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
            throw new SellerException('Shop,server error try again or contact our customer service');
        }
    }
}
