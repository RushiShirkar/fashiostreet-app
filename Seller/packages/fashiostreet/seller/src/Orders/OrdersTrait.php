<?php
namespace fashiostreet\seller\Orders;
use Illuminate\Support\Facades\DB;
use FS_Response;
trait OrdersTrait{
    public function getProduct($shop_id)
    {
        $product = (array) DB::select('CALL GetOrderedProducts(?)',[$shop_id]);
        if(count($product) <= 0)
        {
            return FS_Response::error('message','No product found');
        }
        return FS_Response::success('data',$product);
    }

    public function getPickedUpProducts($shop_id)
    {
        $product = (array) DB::select('CALL GetPickedUpProducts(?)',[$shop_id]);
        if(count($product) <= 0)
        {
            return FS_Response::error('message','No product found');
        }
        return FS_Response::success('data',$product);
    }

    public function getReturnProducts($shop_id)
    {
        $product = (array) DB::select('CALL GetReturnProducts(?)',[$shop_id]);
        if(count($product) <= 0)
        {
            return FS_Response::error('message','No product found');
        }
        return FS_Response::success('data',$product);
    }

    public function getCompletedProducts($shop_id)
    {
        $product = (array) DB::select('CALL getCompletedProducts(?)',[$shop_id]);
        if(count($product) <= 0)
        {
            return FS_Response::error('message','No product found');
        }
        return FS_Response::success('data',$product);
    }

}
