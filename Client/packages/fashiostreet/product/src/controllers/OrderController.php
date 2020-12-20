<?php
namespace fashiostreet\product;
use App\Http\Controllers\Controller;
use fashiostreet\product\Auth\User;
use fashiostreet\product\Traits\OrderTrait;
use fashiostreet\product\Traits\TrackerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use FS_Response;

class OrderController extends Controller {
    use OrderTrait,TrackerTrait;
    protected $user_id;

    function __construct(Request $request)
    {
        $obj = new User();
        $this->user_id = $obj->getUserId($request);
    }

    /*
     * @param
     * address_id
     * product[{product_id,size_id,qty}]
     * @return
     * message
     * */
    public function addOrder(Request $request)
    {
        $obj = new CartController($request);
        DB::beginTransaction();
        $order = $this->createOrder($request,$this->user_id);
        $this->createOrderProductsData($order->id,$this->user_id);
        $obj->DeleteAllFromCart();
        DB::commit();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender=ORDERS&route=4&mobiles=".$request->contact."&authkey=185904AYp2weF2DuY5a1db5f5&country=91&message=Your order has been successfully placed. You will get free home delivery.%0a- Team Fashiostreet",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return response()->json('successfully order placed your order id : '.$order->id);
    }
    /*
     * response : {
     *
     * }
     * */
    public function getNumberOfPromocodeOrder(Request $request,$mobile)
    {
        $user_id = DB::select('select id from customer where mobile=?',[$mobile]);
        $promocode = "SUPER30";
        $count=DB::select('select id from orders where customer_id=? and promocode=?',[$user_id[0]->id,$promocode]);
        return FS_Response::success('data',$count);
    }

    public function saveDiscount(Request $request,$money)
    {
        $id = DB::select('select id from orders order by id DESC LIMIT 1');
        DB::table('orders')
            ->where('id',$id[0]->id)
            ->update([
                'cashback' => $money
            ]);  
        return FS_Response::success('data',$money);
    }

    public function getCashback(Request $request,$id)
    {
        $money = DB::select('select cashback from orders where id=?',[$id]);
      
        return FS_Response::success('data',$money);
        
    }

    public function sendOrderSms(Request $request)
    {	
	//$id = $request->id;
	$shopid = DB::select('select shop_id from product where id=?',[$request->id]);
	$no = DB::select('select contact from shop where id=?',[$shopid[0]->shop_id]);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender=ORDERS&route=4&mobiles=8600198512,7558417359,7767838215,".$no[0]->contact."&authkey=185904AYp2weF2DuY5a1db5f5&country=91&message=Please check fashiostreet. You have new order.",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
	return FS_Response::success('data',$no);

    }

    //Specific Order
    public function specificOrder(Request $request)
    {
        if($request->which=="clothing")
        {
            DB::table('specific_order')->insert([
            'category' => $request->category,
            'price' => $request->price,
            'color' => $request->color,
            'size' => $request->size,
            'description' => $request->description,
            'whatsapp' => $request->mobile
            ]);
            $id = DB::select('SELECT id FROM specific_order ORDER BY id DESC LIMIT 1');
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender=FSENQY&route=4&mobiles=7767838215,7558417359,8600198512&authkey=185904AYp2weF2DuY5a1db5f5&country=91&message=Specific Want Order(Id-".$id[0]->id.")%0aCategory=".$request->category.",%0aPrice=".$request->price.",%0aColor=".$request->color.",%0aSize=".$request->size.",%0aDescription=".$request->description.",%0aCustomer No=".$request->mobile."%0ahttps://wa.me/91".$request->mobile,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
           /* $number = DB::select('select contact from shop where city_id=2');
            for($i=0;$i<count($number);$i++)
            {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender=FSENQY&route=4&mobiles=".$number[$i]->contact."&authkey=185904AYp2weF2DuY5a1db5f5&country=91&message=Specific Want Order (Id - ".$id[0]->id." )%0aCategory=".$request->category."%0aPrice=".$request->price."%0aColor=".$request->color."%0aSize=".$request->size."%0aDescription=".$request->description."%0aYES : https://api.whatsapp.com/send?phone=918600198512%26text=Yes-Specific_Want_Order(Id-".$id[0]->id.")"."%0aNO : https://api.whatsapp.com/send?phone=918600198512%26text=No-Specific_Want_Order(Id-".$id[0]->id.")",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                ));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
            }
            */
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender=FSENQY&route=4&mobiles=".$request->mobile."&authkey=185904AYp2weF2DuY5a1db5f5&country=91&message=Your specific want enquiry has been received successfully.%0a- Team fashiostreet",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            return FS_Response::success('data',$request->mobile);
        }
        if($request->which=="footwear")
        {
            DB::table('specific_order')->insert([
            'category' => $request->category,
            'price' => $request->price,
            'color' => $request->color,
            'size' => $request->size,
            'description' => $request->description,
            'whatsapp' => $request->mobile
            ]);
            $id = DB::select('SELECT id FROM specific_order ORDER BY id DESC LIMIT 1');
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender=FSENQY&route=4&mobiles=7767838215,7558417359,8600198512&authkey=185904AYp2weF2DuY5a1db5f5&country=91&message=Specific Want Order(Id-".$id[0]->id.")%0aCategory=".$request->category.",%0aPrice=".$request->price.",%0aColor=".$request->color.",%0aSize=".$request->size.",%0aDescription=".$request->description.",%0aCustomer No=".$request->mobile."%0ahttps://wa.me/91".$request->mobile,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
           /* $number = DB::select('select contact from shop where city_id=2');
            for($i=0;$i<count($number);$i++)
            {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender=FSENQY&route=4&mobiles=".$number[$i]->contact."&authkey=185904AYp2weF2DuY5a1db5f5&country=91&message=Specific Want Order (Id - ".$id[0]->id." )%0aCategory=".$request->category."%0aPrice=".$request->price."%0aColor=".$request->color."%0aSize=".$request->size."%0aDescription=".$request->description."%0aYES : https://api.whatsapp.com/send?phone=918600198512%26text=Yes-Specific_Want_Order(Id-".$id[0]->id.")"."%0aNO : https://api.whatsapp.com/send?phone=918600198512%26text=No-Specific_Want_Order(Id-".$id[0]->id.")",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                ));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
            }
            */
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender=FSENQY&route=4&mobiles=".$request->mobile."&authkey=185904AYp2weF2DuY5a1db5f5&country=91&message=Your specific want enquiry has been received successfully.%0a- Team fashiostreet",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            return FS_Response::success('data',$request->mobile);
        }
        else if($request->which=="deodorant")
        {
            DB::table('specific_order')->insert([
            'brand' => $request->brand,
            'size' => $request->size,
            'description' => $request->description,
            'whatsapp' => $request->mobile
            ]);
            $id = DB::select('SELECT id FROM specific_order ORDER BY id DESC LIMIT 1');
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender=FSENQY&route=4&mobiles=7767838215,7558417359,8600198512&authkey=185904AYp2weF2DuY5a1db5f5&country=91&message=Specific Want Order(Id-".$id[0]->id.")%0aBrand=".$request->brand.",%0aVolume=".$request->size.",%0aDescription=".$request->description.",%0aCustomer No=".$request->mobile."%0ahttps://wa.me/91".$request->mobile,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender=FSENQY&route=4&mobiles=".$request->mobile."&authkey=185904AYp2weF2DuY5a1db5f5&country=91&message=Your specific want enquiry has been received successfully.%0a- Team fashiostreet",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
                                return FS_Response::success('data',$request->mobile);
        }
        else if($request->which=="raincoat")
        {
            DB::table('specific_order')->insert([
            'brand' => $request->brand,
            'price' => $request->price,
            'color' => $request->color,
            'description' => $request->description,
            'whatsapp' => $request->mobile
            ]);
            $id = DB::select('SELECT id FROM specific_order ORDER BY id DESC LIMIT 1');
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender=FSENQY&route=4&mobiles=7767838215,7558417359,8600198512&authkey=185904AYp2weF2DuY5a1db5f5&country=91&message=Specific Want Order(Id-".$id[0]->id.")%0aBrand=".$request->brand.",%0aPrice=".$request->price.",%0aColor=".$request->color.",%0aDescription=".$request->description.",%0aCustomer No=".$request->mobile."%0ahttps://wa.me/91".$request->mobile,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender=FSENQY&route=4&mobiles=".$request->mobile."&authkey=185904AYp2weF2DuY5a1db5f5&country=91&message=Your specific want enquiry has been received successfully.%0a- Team fashiostreet",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
                                return FS_Response::success('data',$request->mobile);
        }
        else if($request->which=="phonecover")
        {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender=FSENQY&route=4&mobiles=".$request->mobile."&authkey=185904AYp2weF2DuY5a1db5f5&country=91&message=This category is not available right now.Please Update your App. Sorry for the inconvenience.%0a- Team fashiostreet",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
                                return FS_Response::success('data',$request->mobile);
        }
        else if($request->which=="electronicaccs")
        {

                     $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender=FSENQY&route=4&mobiles=".$request->mobile."&authkey=185904AYp2weF2DuY5a1db5f5&country=91&message=We have removed Electronic Accessories category.Please update your app.Sorry for the inconvenience.%0a- Team fashiostreet",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
                                return FS_Response::success('data',$request->mobile);

        }
        else
        {

        }
    }

    public function getOrderHistory(Request $request,$json='view')
    {
        $page = isset($request->page)? (int) $request->page :1;
        $paginate = 15;
        $startFrom = ($page - 1) * $paginate;
        $orderComplete = array();
        $orders = $this->getOrders($this->user_id,$startFrom,$paginate);
        for($i=0;$i < count($orders);$i++)
        {
            $tmp_data = array(
                'order_id' => $orders[$i]->order_id,
                'order_status' => $orders[$i]->status,
                'address' => $orders[$i]->address,
                'contact' => $orders[$i]->contact,
                'cashback' => $orders[$i]->cashback,
                'promocode' => $orders[$i]->promocode,
                'try_buy' => $orders[$i]->try_buy,
                'customer_name' => $orders[$i]->customer_name,
                'completed_at' => $orders[$i]->completed_at,
                'order_date' => $orders[$i]->created_at,
                'products' => $this->getSelectedProduct($orders[$i]->order_id)
            );
            array_push($orderComplete,$tmp_data);
            unset($tmp_data);
        }
        if($json == 'json')
        {
            return FS_Response::success('data',$orderComplete);
        }
        return view('fashiostreet_client::orders_history',['order' => $orderComplete]);
    }
    /*
     * @param
     * order_id
     * */
    public function CancelOrder(Request $request){
        return $this->ChangeOrderStatus($request->order_id,$this->user_id);
    }

    public function confirm_delivery(Request $request,$json = 'view')
    {
        $obj = new CartController($request);
        $product = $obj->GetFromCart($request,'normal');
        $obj = new AddressController($request);
        $address = $obj->getAddressById($request);
        if($json == 'json')
        {
            return FS_Response::success('data',array(
                'product' => $product,
                'address' => $address
            ));
        }
        return view('fashiostreet_client::confirm_delivery',['product' => $product,'address' => $address]);
    }
}
