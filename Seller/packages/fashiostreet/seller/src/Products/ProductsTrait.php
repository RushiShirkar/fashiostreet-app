<?php
namespace fashiostreet\seller\Products;

use fashiostreet\seller\Colors\ColorTraits;
use fashiostreet\seller\Common\CommonRepository;
use fashiostreet\seller\Exceptions\ErrorException;
use fashiostreet\seller\Exceptions\SellerException;
use fashiostreet\seller\Sizes\SizesTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait ProductsTrait{

    use CommonRepository,SizesTrait,ColorTraits;

    protected $shop;

    function __construct(Request $request)
    {
       $this->shop = array('id' => $request->header('shopId'));
    }

    public function getProductColor($product_id){
        $colors = DB::select('select color.name from product_color left join color on color.id = product_color.color_id where product_color.product_id = ?',[$product_id]);
        if(count($colors) > 0) {
            return $colors[0]->name;
        }
        return null;
    }

    /* get Product data */
    public function getProducts($c_s_g_id,$StartFrom,$paginate,$shop_id)
    {
        $product = (array) DB::select('CALL GetProducts(?,?,?,?)',[$c_s_g_id,$shop_id,$StartFrom,$paginate]);
        
        if(count($product) <= 0)
        {
            throw new ErrorException('No product found');
        }
        return $product;
    }

    /* get product details */
    protected function getProduct($product_id)
    {
        $product  = (array) DB::select('CALL GetProduct(?)',[$product_id]);
        if(count($product) <= 0)
        {
            throw new ErrorException('No product details found');
        }
        return $product;
    }


    protected function SaveProduct($shop_id,$productData)
    {
        $productData = (object) $productData;
        $product = (array) DB::select('CALL AddProduct(?,?,?,?,?,?,?,?,?,?,?,?)',
                    [
                        $productData->c_s_g_id,
                        $shop_id,
                        $productData->brand_id,
                        $productData->type_id,
                        $productData->name,
                        $productData->image,
                        $productData->s_p_id,
                        $productData->mrp_price,
                        $productData->selling_price,
                        $productData->discount,
                        $productData->description,
                        $productData->keyword
                    ]);
        
        if(count($product) <= 0)
        {
            throw new SellerException('failed to upload product');
        }
        return $product;
    }

    /* update product details
     * @param
     * product_id (int)
     * updated_value (array)
     */
    protected function updateProduct($product_id,$updated_value)
    {
        $temp_data = array();
        $temp_keys = array_keys($updated_value);
        for ($i=0;$i < count($temp_keys);$i++){
            $temp_data = array_merge($temp_data,[$temp_keys[$i] => $updated_value[$temp_keys[$i]]]);
        }
        $updated_value = $temp_data;
        if(isset($updated_value['brand'])){
            $updated_value = $this->checkBrand($updated_value);
        }
        if(isset($updated_value['type'])){
            $updated_value = $this->checkType($updated_value);
        }
        DB::table('product')
            ->where('id',$product_id)
            ->update($updated_value);
        return true;
    }

    public function DeleteAllProductSizes($product_id){
        try{
            DB::table('product_size')->where(['product_id' => $product_id])->delete();
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            throw new SellerException('Failed to update Product_sizes error code:1');
        }
    }

    protected function checkType($updated_value)
    {
        if(array_key_exists('type',$updated_value))
        {
            $type_id = $this->getType_id($updated_value['type']);
            $updated_value['type_id'] = $type_id[0]->id;
            unset($type_id);
        }
        return $updated_value;
    }
    /* check brand */
    protected function checkBrand($updated_value)
    {
        if(array_key_exists('brand',$updated_value))
        {
            $brand_id = $this->getBrand_id($updated_value['brand']);
            $updated_value['brand_id'] = $brand_id[0]->id;
        }
        return $updated_value;
    }
    /* check c_s_g_id */
    protected function checkc_s_g_id($updated_value)
    {
        if(array_key_exists('gender',$updated_value) && array_key_exists('category',$updated_value) && array_key_exists('sub_category',$updated_value))
        {
            $c_s_g_id = $this->getC_S_G_id($updated_value['gender'],$updated_value['category'],$updated_value['sub_category']);
            $updated_value['category_sub_gender_id'] = $c_s_g_id;
            $index = array_search('gender',$updated_value);
            unset($updated_value[$index]);
            $index = array_search('category',$updated_value);
            unset($updated_value[$index]);
            $index = array_search('sub_category',$updated_value);
            unset($updated_value[$index]);
        }
        return $updated_value;
    }

    /* delete product data */
    protected function delete($product_id)
    {
        DB::beginTransaction(); 
        DB::table('product_size')->where('product_id', '=', $product_id)->delete();
        DB::table('product_color')->where('product_id', '=', $product_id)->delete();
        DB::table('cart')->where('product_id', '=', $product_id)->delete();
        DB::table('wishlist')->where('product_id', '=', $product_id)->delete();
        DB::table('product')->where('id', '=', $product_id)->delete();
        DB::commit();
        return true;
    }


    protected function withError($callback)
    {
        try
        {
            return $callback();
        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e)
        {
            throw new ErrorException('No product found,Invalid product details found');
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            throw new SellerException('Product,server error please try again or contact our customer service');
        }
    }
}
