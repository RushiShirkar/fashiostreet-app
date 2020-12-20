<?php
namespace fashiostreet\seller\Products;
use fashiostreet\api_auth\Exceptions\SystemException;
use fashiostreet\seller\Image\ImageRepository;
use fashiostreet\seller\Sizes\SizesTrait;
use Illuminate\Http\Request;
use fashiostreet\seller\Products\ProductsTrait;
use Illuminate\Support\Facades\DB;
use Validate;
use FS_Response;
use FS_Image;
class ProductsRepository{
    use ProductsTrait;

    protected $StartFrom;
    protected $paginate = 60;
    protected $shop_id;

    function __construct(Request $request)
    {
        $page = isset($request->page) ? (int)$request->page : 1;
        $this->StartFrom = (((int)$page - 1) * $this->paginate);
        unset($page);   //deallocate page variable;
        $this->shop_id = array('id' => $request->header('shopId'));
    }
    public function storeImage(Request $request)
    {
        $filename = time().'.'.request()->img->getClientOriginalExtension();
request()->img->move(public_path('images'), $filename);

$user->image=$filename;
$user->save();
    }
    public function getVersion(){
        $version = '1.0';
        return FS_Response::success('data',$version);
    }

    public function GetTabsProductDetails(Request $request)
    {
        if(!isset($request->product_id)){
            return FS_Response::error(500,"product id parameter missing");
        }
        if(!Validate::numericOnly($request->product_id)){
            return FS_Response::error(500,"Invalid product id parameter value");
        }
        $product = $this->getProduct($request->product_id);
        return FS_Response::success('data',$this->withSizesAndColors($product));
    }

    public function GetTabsProduct(Request $request)
    {
        if(isset($request->gender) && isset($request->category) && isset($request->sub_category))
        {
            $c_s_g_id = $this->getC_S_G_id($request->gender,$request->category,$request->sub_category);
            $product = $this->getProducts($c_s_g_id,$this->StartFrom,$this->paginate,$this->shop_id['id']);
        }
        else
        {
            $product = $this->getProducts(0,$this->StartFrom,$this->paginate,$this->shop_id['id']);
        }
        $product = array_reverse($product);
        return FS_Response::success('data',$this->withSizes($product));
    }

    protected function withSizes($product)
    {
        for($i=0;$i < count($product);$i++)
        {
            $product[$i]->{'sizes'} = $this->getSizes($product[$i]->id);
        }
        return $product;
    }

    protected function withSizesAndColors($product)
    {
        for($i=0;$i < count($product);$i++)
        {
            $product[$i]->{'color'} = $this->getProductColor($product[$i]->id);
            $product[$i]->{'sizes'} = $this->getSizes($product[$i]->id);
        }
        return $product;
    }

    public function AddTabProduct(Request $request)
    {
        $image_obj = new ImageRepository();
        $image = '';

        for($i=0;$i<count($request->image);$i++)
        {
            $image = $image.$image_obj->CreateImageName($request->extension,$request->name.'-side'.$i).',';
        }
        $image = rtrim($image,',');

        DB::beginTransaction();
        $tmp = $this->getC_S_G_id($request->gender,$request->category,$request->sub_category);
        
        $product['c_s_g_id'] = $tmp;
        unset($tmp);
        $product['brand_id'] = $this->getBrand_id($request->brand);
        $product['type_id'] = $this->getType_id($request->type);
        $product['name'] = $request->name;
        $product['image'] = $image;
        $product['s_p_id'] = $request->s_p_id;
        $product['mrp_price'] = $request->mrp_price;
        $product['selling_price'] = $request->selling_price;
        $product['discount'] = $request->discount;
        $product['description'] = $request->description;
        $product['keyword'] = $request->name;

        $product = (array) $this->SaveProduct($request->shop_id,$product);

        for($i=0;$i < count($request->sizes);$i++) //add sizes
        {
            $size = array(
                'size_id' => $this->getSize_id($request->sizes[$i]['size']),
                'product_id' => $product[0]->product_id,
                'qty' => $request->sizes[$i]['qty']
            );
            $this->addSize($size);
        }

        for($i=0;$i < count($request->colors);$i++) //add colors
        {
            $data = array(
                'color_id' => $this->getColor_id($request->colors[$i]),
                'product_id' => $product[0]->product_id
            );
            $this->AddColor($data);
        }

        $tmp_image = $image;
        $image = explode(",",$image);
        for($i=0;$i < count($request->image);$i++)
        {
            if(!$image_obj->uploadProductImage($request->image[$i],$image[$i],$request->extension))
            {
                $image_obj->DeleteProductOriginalImage($tmp_image);
                throw new SystemException('Error while uploading image');
            }
        }
        DB::commit();
        return FS_Response::success('message','successfully product uploaded');
    }

    public function DeleteProductByBarcode(Request $request)
    {
        $size = explode('-', $request->barcodeId, 2)[1];
        $arr = explode("-", $request->barcodeId, 2);
        $barcodeId = $arr[0];
        $id = DB::select('select id from product where barcodeId=?',[$barcodeId]);
        $sizes = DB::select('select id from product_size where product_id=?',[$id[0]->id]);
        $size_id = DB::select('select id from size where name=?',[$size]);
        $count = count($sizes);
        $qty = DB::select('select qty from product_size where product_id=? and size_id=?',[$id[0]->id,$size_id[0]->id]);
        if($count==1)
        {
            if($qty[0]->qty>1)
            {
                $qty = $qty[0]->qty - 1;
                $updateqty = DB::table('product_size')
                    ->where('product_id', $id[0]->id)
                    ->where('size_id',$size_id[0]->id)
                    ->update(['qty' => $qty]);
            }
            if($qty[0]->qty<=1)
            {
                $product = (array)ProductsModel::where('id',$id[0]->id)
                                ->delete();
                $size = $this->deleteAllSizes($id[0]->id);
                $color = $this->DeleteAllColors($id[0]->id);
                $image_name = (array) DB::select('select image from product where id = ?',[$id[0]->id]);
                $image_name = $image_name[0]->image;
                $image_obj = new ImageRepository();
                $image_obj->DeleteProductOriginalImage($image_name);
                $image_obj->DeleteAllProductImages($image_name);
                DB::commit();
            }
        }
        if($count>1)
        {
            if($qty[0]->qty>1)
            {
                $qty = $qty[0]->qty - 1;
                $updateqty = DB::table('product_size')
                    ->where('product_id', $id[0]->id)
                    ->where('size_id',$size_id[0]->id)
                    ->update(['qty' => $qty]);
            }
            if($qty[0]->qty<=1)
            {
                DB::table('product_size')->where('product_id', $id[0]->id)->where('size_id',$size_id[0]->id
                    )->delete();
            }
        }
        return FS_Response::success('message',"success");
    }

    public function DeleteTabsProduct(Request $request)
    {
        if(!isset($request->product_id)){
            return FS_Response::error(500,'product Id parameter missing');
        }
        $image_name = (array) DB::select('select image from product where id = ?',[$request->product_id]);
        $image_name = $image_name[0]->image;
        DB::beginTransaction();
        //console.log($image_name);
        //$image_name->delete();
        if($this->delete($request->product_id))
        {
            $image_obj = new ImageRepository();
            $image_obj->DeleteProductOriginalImage($image_name);
            $image_obj->DeleteAllProductImages($image_name);
            DB::commit();
            return FS_Response::success('message','successfully product deleted');
        }
        else{
            DB::rollBack();
            return FS_Response::error(500,'failed to delete product');
        }
    }

    /**
     * Product id *
     * Updated fields from database
     * productData for product table field only
     * sizeData for size table field only
     * sizesinsert data [{size:,qty}][{}][{}] format
     * ColorData for color table field only
     * color[{color:}]
     * */
    public function UpdateTabsProduct(Request $request){

        try{
            

        if(!isset($request->product_id)){
            return FS_Response::error(500,'Missing product id');
        }

        $update = DB::table('product')
            ->where('id', $request->product_id)
            ->update(['name' => $request->name,'mrp_price' => $request->mrp_price,'selling_price' => $request->selling_price,'discount' => $request->mrp_price - $request->selling_price,'description' => $request->description]);
            
            $colorid = DB::table('color')->where('name', $request->color)->value('id');
            
            $updatecolor = DB::table('product_color')
            ->where('product_id', $request->product_id)
            ->update(['color_id' => $colorid]);


            DB::table('product_size')->where('product_id', '=', $request->product_id)->delete();
            
            foreach($request->itemSizes as $values)
         {
            $sizeid = DB::table('size')->where('name', $values["name"])->value('id');
              DB::table('product_size')->insert(
                ['product_id' => $request->product_id, 'size_id' => $sizeid, 'qty' => $values["qty"]]
            );            
         }


         

        return FS_Response::success('message','success');
    }
    catch(\Illuminate\Database\QueryException $e){

        throw new ErrorException('Server error found '.$e->getCode());

    }
}
}
