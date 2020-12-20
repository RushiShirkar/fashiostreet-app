<?php
namespace fashiostreet\product;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use fashiostreet\product\Auth\User;
use fashiostreet\product\Exceptions\ErrorException;
use fashiostreet\product\Exceptions\SystemException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use FS_Response;

class CartController extends Controller{

    protected $user_id;

    function __construct(Request $request)
    {
        $obj = new User();
        $this->user_id =$obj->getUserId($request);
    }
    /*
     * required @cart_id and @product_id
     * */
    public function movetowishlist(Request $request)
    {
        $obj = new UserController($request);
        DB::beginTransaction();
        if($obj->add($this->user_id,$request))
        {
            if($this->delete($request))
            {
                DB::commit();
                return FS_Response::success('message','successfully product moved to wishlist');
            }
            DB::rollBack();
            return FS_Response::error(500,'failed to move');
        }
        DB::rollBack();
        return FS_Response::error(500,'product already in wishlist');
    }

    public function GetFromCart(Request $request,$json='view')
    {
        $cartProduct = (array) DB::select('select product.id as id,cart.id as cart_id, product.name as name, product.image as image, product.mrp_price as mrp_price, product.selling_price as selling_price, cart.qty as qty, shop.name as shop_name, size.name as size, brand.name as brand, color.name as color from cart left join product on product.id = cart.product_id left join size on size.id = cart.size_id left join brand on brand.id = product.brand_id left join product_color ON product_color.product_id = cart.product_id left join color on color.id = product_color.color_id left join shop on shop.id = product.shop_id where cart.users_id = ? and cart.deleted_at IS NULL',[$this->user_id]);
        for($i=0;$i < count($cartProduct);$i++)
        {
            $image = explode(',',$cartProduct[$i]->image);
            $image = array_reverse($image);
            $cartProduct[$i]->image = array('https://seller.fashiostreet.com/products/compress220X258/'.$image[0]);
            $info = DB::select('select category_sub_gender_id,shop_id from product where id = ?',[$cartProduct[$i]->id]);
                $check = DB::select('select * from specialshopdiscount where shop_id = ? and subcategory_id = ?',[$info[0]->shop_id,$info[0]->category_sub_gender_id]);
                $discount = (($cartProduct[$i]->mrp_price - $cartProduct[$i]->selling_price)/$cartProduct[$i]->mrp_price)*100;
                if(count($check)>0 && $discount<=$check[0]->discount)
                {
                    $cartProduct[$i]->specialDiscount = true;
                    $cartProduct[$i]->specialDiscountedPrice = $cartProduct[$i]->mrp_price - (($cartProduct[$i]->mrp_price*$check[0]->discount)/100);
                    $cartProduct[$i]->specialDiscountedPercentage = $check[0]->discount;
                }
                else
                {
                    $cartProduct[$i]->specialDiscount = false;
                }
                $info = null;
                $check = null;
                $cartProduct[$i]->mrp_price = round($cartProduct[$i]->mrp_price);
                $cartProduct[$i]->selling_price = round($cartProduct[$i]->selling_price);
        }
        if($json == 'json')
        {
            return FS_Response::success('message',$cartProduct);
        }
        else if($json == 'normal')
        {
            return $cartProduct;
        }
        return view('fashiostreet_client::cart',['product' => $cartProduct]);
    }

    public function AddToCart(Request $request)
    {
        try{
            $obj = new product();
            $size_id = $obj->getSizeId2($request->size);
            $cart = (array)DB::select('select id from cart where users_id = ? and product_id = ? and size_id = ? and deleted_at IS NULL limit 1',[$this->user_id,$request->product_id,$size_id[0]->id]);
            if(count($cart) > 0)
            {
                return FS_Response::error(500,'product already in cart');
            }
            if($size_id == false)
            {
                throw new ErrorException('invalid size found');
            }
            DB::table('cart')
                ->insert([
                    'product_id' => $request->product_id,
                    'qty' => 1,
                    'size_id' => $size_id[0]->id,
                    'users_id' => $this->user_id
                ]);
            return FS_Response::success('message','successfully product inserted');
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            throw new SystemException('server error,while inserting into cart');
        }

    }

    public function DeleteFromCart(Request $request)
    {
        if($this->delete($request))
        {
            return FS_Response::success('message','product remove from cart');
        }
        return FS_Response::error(500,'failed remove product from cart');
    }

    public function delete($request)
    {
        $cartDeletedProduct = DB::table('cart')
            ->where('users_id',$this->user_id)
            ->where('id',$request->cart_id)
            ->update([
                'deleted_at' => Carbon::now()
            ]);
        if($cartDeletedProduct <= 0 || $cartDeletedProduct == false || $cartDeletedProduct == null)
        {
            return false;
        }
        return true;
    }

    public function DeleteAllFromCart()
    {
        $cartDeletedProduct = DB::table('cart')
            ->where('users_id',$this->user_id)
            ->update([
                'deleted_at' => Carbon::now()
            ]);
        if($cartDeletedProduct <= 0 || $cartDeletedProduct == false || $cartDeletedProduct == null)
        {
            return false;
        }
        return true;

    }
}
