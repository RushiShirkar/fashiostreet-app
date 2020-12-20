<?php
namespace fashiostreet\seller\Tabs;

use Carbon\Carbon;
use fashiostreet\seller\Common\CommonRepository;
use fashiostreet\seller\Exceptions\ErrorException;
use fashiostreet\seller\Exceptions\SellerException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait TabsDB
{
    use CommonRepository;

    protected $paginate = 15;
    protected $StartFrom;
    protected $user;


    //check limit logic e.g : limit 15(paginate),1(start)
    function __construct(Request $request)
    {
        $page = isset($request->page) ? (int)$request->page : 1;
        $this->StartFrom = (((int)$page - 1) * $this->paginate);
        unset($page);   //deallocate page variable;
        $this->user = array('shop_id' => $request->header('shopId'));   //auth user varibale
    }

    protected function getAll()
    {
        return $this->withError(function (){
            return DB::select('CALL GetTabs(?,?,?)',[$this->user['shop_id'],$this->StartFrom,$this->paginate]);
        });
    }


    protected function checkTabExistOrNot($id,$flag = true)
    {
        return $this->withError(function () use ($id,$flag){
            $tab = (array) DB::select('select id from tabs where shop_id = ? and category_sub_gender_id = ? and deleted_at IS NULL limit 1',[$this->user['shop_id'],$id]);
            if(count($tab) > 0)
            {
                if($flag)
                   throw new ErrorException('Tab Already Exist');
                else
                    return false;
            }
            return true;
        });
    }

    protected function add($c_s_g_id)
    {
        return $this->withError(function () use ($c_s_g_id){
            $this->checkTabExistOrNot($c_s_g_id);
            return DB::select('call AddTab(?,?)',[$this->user['shop_id'],$c_s_g_id]);
        });
    }



    protected function delete($c_s_g_id)
    {
        return $this->withError(function () use ($c_s_g_id){
            if(!$this->checkTabExistOrNot($c_s_g_id,false)) {
                $tab = DB::table('tabs')
                    ->where(['shop_id' => $this->user['shop_id'], 'category_sub_gender_id' => $c_s_g_id])
                    ->update(['deleted_at' => Carbon::now()]);
                if ($tab <= 0 || $tab == false || $tab == null)
                    throw new ErrorException('failed to delete tab');
                return $tab;
            }
            else {
                throw new ErrorException('no tab found');
            }
        });
    }
}
