<?php

namespace fashiostreet\product;

use Carbon\Carbon;
use fashiostreet\product\Auth\User;
use fashiostreet\product\Exceptions\ErrorException;
use FS_Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    const user_field = [
        ''
    ];
    protected $user;
    protected $startFrom;
    protected $paginate = 15;
    function __construct(Request $request)
    {
        $this->user = new User();
        $page = isset($request->page) ? (int)$request->page : 1;
        $this->StartFrom = (((int)$page - 1) * $this->paginate);
        unset($page);   //deallocate page variable;

    }

    public function frameView()
    {
        return view('fashiostreet_client::layout.user');
    }

    public function sendReferal(Request $request)
    {
        $checkReferal = DB::select('select * from customer where mobile = ?',[$request->referal]);
        if(count($checkReferal) > 0)
        {
            DB::table('referal')->insert([
                'mobile' => $request->mobile,
                'refer_no' => $request->referal
            ]);
            $user1 = DB::select('select * from customer where mobile = ?',[$request->mobile]);
            $user2 = DB::select('select * from customer where mobile = ?',[$request->referal]);
            $user1_money = DB::select('select money from customer_wallet where customer_id = ?',[$user1[0]->id]);
            $user2_money = DB::select('select money from customer_wallet where customer_id = ?',[$user2[0]->id]);
            $money1 = $user1_money[0]->money + 20;
            $money2 = $user2_money[0]->money + 30;
            DB::table('customer_wallet')
            ->where('customer_id',$user1[0]->id)
            ->update([
                'money' => $money1
            ]);
            DB::table('customer_wallet')
            ->where('customer_id',$user2[0]->id)
            ->update([
                'money' => $money2
            ]);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender=Fashio&route=4&mobiles=".$request->referal."&authkey=185904AYp2weF2DuY5a1db5f5&country=91&message=Rs.30 cashback added to your Fashiostret wallet.",
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
        else
        {
            return FS_Response::error(500,'Enter valid Referal code');
        }
        return FS_Response::success('message',"Success");
    }

    public function sendReferalMsg(Request $request)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender=Fashio&route=4&mobiles=".$request->refermobile."&authkey=185904AYp2weF2DuY5a1db5f5&country=91&message=Refer Code:".$request->mobile."%0aDownload Fashiostreet app and enjoy shopping from different shops of your city from home.%0aGet Rs.25 cashback by using above refer code at time of login.%0aAlso,share your referal code from app to get Rs.25 cashback at each referal.%0aApp Download Link:https://bit.ly/2v3hD8b%0a",
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
        return FS_Response::success('data',$request->refermobile);
    }

    public function addUpcomingFeature(Request $request)
    {
        DB::table('upcoming_feature')->insert([
            'name' => $request->feature
        ]);
        return FS_Response::success('message',"Success");
    }

    public function saveFeedback(Request $request)
    {
        DB::table('feedback')->insert([
            'mobile' => $request->mobile,
            'performance' => $request->performance,
            'variety' => $request->variety,
            'aboutus' => $request->aboutus,
            'hear' => $request->hear,
            'feedback' => $request->improve,
	    'created_at' => Carbon::now()
        ]);
        return FS_Response::success('message',"Success");
    }

    public function addUserWallet(Request $request,$mobile)
    {
        $id = DB::select('select id from customer where mobile=?',[$mobile]);
        DB::table('customer_wallet')->insert([
            'customer_id' => $id[0]->id,
            'money' => 0
        ]);
        return FS_Response::success('message',"Success");
    }

    public function updateMoney(Request $request)
    {
        $id = DB::select('select id from customer where mobile=?',[$request->mobile]);
        DB::table('customer_wallet')
            ->where('customer_id',$id[0]->id)
            ->update([
                'money' => $request->money
            ]);
        return FS_Response::success('data',$request->money);
    }

    public function getWalletMoney(Request $request,$mobile)
    {   
        $id = DB::select('select id from customer where mobile=?',[$mobile]);
        $money = DB::select('select money from customer_wallet where customer_id=?',[$id[0]->id]);
        return FS_Response::success('data',$money);
    }

    public function add($user_id,$request){
        try
        {
            if(!$this->checkProductInWishlist($user_id,$request->product_id,'json')) {
                $wishlist = new wishlist();
                $wishlist->users_id = $user_id;
                $wishlist->product_id = $request->product_id;
                $wishlist->save();
                return 'Successfully Added To Wishlist';
            }
            return false;
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            throw new ErrorException('System error found,wishlist');
        }
    }

    public function add_wishlist(Request $request,$json = 'view')
    {
        $user_id = $this->user->getUserId($request);    //set through sentinel
        $status = $this->add($user_id,$request);
        if($status)
        {
            return FS_Response::success('message',$status);
        }
        return FS_Response::error(500,'product already in wishlist');
    }

    protected function checkProductInWishlist($user_id,$product_id,$json = 'view'){
        try
        {
            $product = (array) DB::select('select id from `wishlist` where users_id = ? and product_id = ? and deleted_at IS NULL limit 1',[$user_id,$product_id]);
            if(count($product) <= 0)
            {
                return false;
            }
            return true;
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            if($json == 'json')
            {
                throw new ErrorException('wishlist,server error found please try agian or contact our customer service');
            }
            $error = array('error' => 'Server error found please,Try again');
            return view('fashiostreet_client::error500',['request' => $error]);
        }
    }


    public function delete_wishlist(Request $request,$json = 'view')
    {
        $user_id = $this->user->getUserId($request);

            try
            {
                if($this->checkProductInWishlist($user_id,$request->product_id,$json)) {
                        DB::table('wishlist')
                        ->where('users_id', $user_id)
                        ->where('product_id', $request->product_id)
                        ->update([
                            'deleted_at' => Carbon::now()
                        ]);
                    if($json == 'json')
                    {
                        return FS_Response::success('message', 'product sucessfully remove from wishlist');
                    }
                    //return view here
                }
                if($json == 'json')
                {
                    return FS_Response::error('message','no product found at wishlist');
                }
                //return error view here;
            }
            catch (\Illuminate\Database\QueryException $e)
            {
                if($json == 'json')
                {
                    throw new ErrorException('wishlist,server error found please try agian or contact our customer service');
                }
                $error = array('error' => 'Server error found please,Try again');
                return view('fashiostreet_client::error500',['request' => $error]);
            }
    }

    protected function withImagePath($wishlist)
    {
        for($i=0;$i < count($wishlist);$i++)
        {
            $wishlist[$i]->image = 'https://seller.fashiostreet.com/products/compress/'.$wishlist[$i]->image;
        }
        return $wishlist;
    }

    public function view_wishlist(Request $request,$json = 'view')
    {
        $user_id = $this->user->getUserId($request);   //set through sentinel;
        try
        {
            $wishlist = DB::select('select product.id as id,shop.name as shop_name,product.image,product.name,product.mrp_price,product.selling_price from `wishlist` left join product ON product.id = wishlist.product_id left join shop on product.shop_id = shop.id where wishlist.users_id = ? and wishlist.deleted_at IS NULL limit ?,?',[$user_id,$this->startFrom,$this->paginate]);
            for($i=0;$i < count($wishlist);$i++)
            {
                $image = explode(',',$wishlist[$i]->image);
                $image = array_reverse($image);
                $wishlist[$i]->image = array('https://seller.fashiostreet.com/products/compress220X258/'.$image[0]);
                $size = DB::select('SELECT size.name as size from product_size LEFT JOIN size on size.id = product_size.size_id WHERE product_id = ? and product_size.deleted_at IS NULL', [$wishlist[$i]->id]);
                $wishlist[$i]->size = $size;
                $info = DB::select('select category_sub_gender_id,shop_id from product where id = ?',[$wishlist[$i]->id]);
                $check = DB::select('select * from specialshopdiscount where shop_id = ? and subcategory_id = ?',[$info[0]->shop_id,$info[0]->category_sub_gender_id]);
                $discount = (($wishlist[$i]->mrp_price - $wishlist[$i]->selling_price)/$wishlist[$i]->mrp_price)*100;
                $offer = DB::select('select offers from shop where id = ?',[$info[0]->shop_id]);
                $wishlist[$i]->offers = $offer[0]->offers;
                if(count($check)>0 && $discount<=$check[0]->discount)
                {
                    $wishlist[$i]->specialDiscount = true;
                    $wishlist[$i]->specialDiscountedPrice = $wishlist[$i]->mrp_price - (($wishlist[$i]->mrp_price*$check[0]->discount)/100);
                    $wishlist[$i]->specialDiscountedPercentage = $check[0]->discount;
                }
                else
                {
                    $wishlist[$i]->specialDiscount = false;
                }
                $info = null;
                $check = null;
            }
            if($json == 'json')
            {
                return FS_Response::success('message',$wishlist);
            }
            return view('fashiostreet_client::wishlist',['products' => $wishlist]);
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            if($json == 'json')
            {
                throw new ErrorException('wishlist,server error found please try agian or contact our customer service');
            }
            $error = array('error' => 'Server error found please,Try again');
            return view('fashiostreet_client::error500',['request' => $error]);
        }
    }

    public function add_history(Request $request)
    {
        $user_id = 1;    //set through sentinel
        try
        {
            $userhistory = new userhistory();
            $userhistory->users_id = $user_id;
            $userhistory->product_id = $request->product_id;
            $userhistory->save();
            return $this->json_success('Successfully Added To Wishlist');
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            return $this->json_error('Server Not Found');
        }
    }

    public function view_userhistory(Request $request)
    {
        $user_id = 1;   //set through sentinel;
        try
        {
            $userhistory = DB::select('select product.id as id,product.image,product.name,product.mrp_price,product.selling_price,shop.name from `userhistory` left join product ON product.id = userhistory.product_id left JOIN shop ON shop.id = product.shop_id where userhistory.users_id = ? limit ?,?',[$user_id,$min,$max]);
            if(count($userhistory) > 0)
            {
                return $userhistory;
            }
            return $this->json_success([]);
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            return $this->json_error('Server Not Found');
        }
    }

    protected function getUserById($id,$json)
    {
        try {
            $user = (array)DB::select('select id,name,gender,mobile from customer where id = ? limit 1', [$id]);
            if (count($user) <= 0) {
                throw new ErrorException('No user found');
            }
            return $user;
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            if($json == 'json')
            {
                throw new ErrorException('user,server error found please try agian or contact our customer service');
            }
            $error = array('error' => 'Server error found please,Try again');
            return view('fashiostreet_client::error500',['request' => $error]);
        }

    }
    /*
     * Get user profile
     * */
    public function getUser(Request $request,$json='view')
    {
        try
        {
            $user_id = $this->user->getUserId($request);
            $user = $this->getUserById($user_id,$json);
            if($json == 'json')
            {
                return FS_Response::success('data',$user);
            }
            return view('fashiostreet_client::profile',['user' => $user]);
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            if($json == 'json')
            {
                throw new ErrorException('wishlist,server error found please try agian or contact our customer service');
            }
            $error = array('error' => 'Server error found please,Try again');
            return view('fashiostreet_client::error500',['request' => $error]);
        }
    }

    /*
     * Update user profile
     * */
    public function update_user(Request $request)
    {
        try
        {
            $user_id = $this->user->getUserId($request);
            $user = DB::table('customer')
                        ->where('id',$user_id)
                        ->update([
                            'name' => $request->name,
                            'gender' => $request->gender,
                        ]);
            if($user <= 0 || $user == false || $user == null)
            {
                return FS_Response::error(500,'no update found');
            }
            return FS_Response::success('message','user successfully updated');
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            throw new ErrorException('wishlist,server error found please try agian or contact our customer service');
        }
    }
    //User Name
    public function user_name(Request $request)
    {
        try
        {
            $user_id = $this->user->getUserId($request);
            $user = DB::table('customer')->where('id',$user_id);
            if($user <= 0 || $user == false || $user == null)
            {
                return FS_Response::error(500,'no user found');
            }
            return FS_Response::success('message',$user);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            throw new ErrorException('server error found please try agian or contact our customer service');
        }
    }

    /*
     * error json private function
     * */
    private function json_error($error)
    {
        return response()->json($error,500);
    }

    private function error($error)
    {
        return view('fashiostreet_client::error500?error='.$error);
    }

    /*
     * success json private function
     * */

    private function json_success($message)
    {
        return response()->json($message,200);
    }
}
