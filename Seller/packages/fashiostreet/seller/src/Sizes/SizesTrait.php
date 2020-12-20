<?php
namespace fashiostreet\seller\Sizes;
use Carbon\Carbon;
use fashiostreet\seller\Exceptions\SellerException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

trait SizesTrait{
    /* get product sizes */
    protected function getSizes($product_id)
    {
        return $this->withError(function () use ($product_id){
            return DB::select('CALL GetSizes(?)',[$product_id]);
        });
    }
    //sizes [[],[]] formate
    protected function addSize($sizes)
    {
       try {
           $sizes = DB::table('product_size')->insert([
               'size_id' => $sizes['size_id'],
               'product_id' => $sizes['product_id'],
               'qty' => $sizes['qty']
           ]);
           if ($sizes <= 0 || $sizes == false || $sizes == null) {
               throw new SellerException('failed to load sizes');
           }
           return true;
       }
       catch (QueryException $exception){
           return FS_Response::error(500,'Failed to insert sizes');
       }
    }
    //delete sizes
    protected function deleteSize($product_id,$size_id)
    {
        return $this->withError(function () use ($product_id,$size_id){
            $sizes = DB::table('product_size')
                        ->where('product_id',$product_id)
                        ->where('size_id',$size_id)
                        ->update([
                            'deleted_at' => Carbon::now()
                        ]);
            if($sizes <= 0 || $sizes == false || $sizes == null)
            {
                throw new SellerException('failed to delete size');
            }
            return true;
        });
    }

    protected function deleteAllSizes($product_id)
    {
        return $this->withError(function () use ($product_id){
            $sizes = DB::table('product_size')
                ->where('product_id',$product_id)
                ->update([
                    'deleted_at' => Carbon::now()
                ]);
            return true;
        });
    }
    protected function updateSize($product_id,$sizes)
    {
        return $this->withError(function () use ($product_id,$sizes){
           $size = DB::table('product_size',$product_id)
                    ->where('product_id',$sizes)
                    ->where('size_id',$sizes['size_id'])
                    ->update(['qty' => $sizes['qty']]);
            if($sizes <= 0 || $sizes == false || $sizes == null)
            {
                throw new SellerException('failed to update size');
            }
            return true;
        });
    }

    protected function withError($callback)
    {
        try
        {
            $callback();
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            throw new SellerException('Sizes,server error try again or contact our customer service');
        }
    }
}
