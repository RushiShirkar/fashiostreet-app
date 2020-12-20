<?php
namespace fashiostreet\seller\Colors;
use Carbon\Carbon;
use fashiostreet\seller\Exceptions\SellerException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
trait ColorTraits{
    public function AddColor($data){
       try {
           $color = DB::table('product_color')->insert([
               'product_id' => $data['product_id'],
               'color_id' => $data['color_id']
           ]);
           if ($color <= 0 || $color == null || $color == false) {
               throw new SellerException('failed to add size to product');
           }
           return $color;
       }
       catch (QueryException $exception){
           return FS_Response::error(500,'failed to insert colors');
       }
    }
    public function DeleteColor($product_id,$color_id)
    {
        return $this->withError(function () use ($product_id,$color_id){

                $color = DB::table('product_color')
                    ->where('product_id',$product_id)
                    ->where('color_id',$color_id)
                    ->update([
                        'deleted_at' => Carbon::now()
                    ]);

            if($color <= 0 || $color == false || $color == null)
            {
                throw new SellerException('failed to delete color from product');
            }
            return $color;
        });
    }

    protected function DeleteAllColors($product_id)
    {
        return $this->withError(function () use ($product_id){
            $color = $color = DB::table('product_color')->where('product_id',$product_id)->update([
                    'deleted_at' => Carbon::now()
                ]);
            return $color;
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
