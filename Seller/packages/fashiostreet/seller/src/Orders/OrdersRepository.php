<?php
namespace fashiostreet\seller\Orders;
use fashiostreet\seller\Orders\OrdersTrait as OrdersTrait;
use Illuminate\Http\Request;

class OrdersRepository {
    use OrdersTrait;

    protected $StartFrom;
    protected $paginate = 30;
    protected $shop_id;

    function __construct(Request $request)
    {
       // $page = isset($request->page) ? (int)$request->page : 1;
        //$this->StartFrom = (((int)$page - 1) * $this->paginate);
        //unset($page);   //deallocate page variable;
        $this->shop_id = array('id' => $request->header('shopId'));
    }

    public function GetOrderProduct()
    {
        return $this->getProduct($this->shop_id['id']);
    }

    public function GetPickedUpProduct()
    {
        return $this->getPickedUpProducts($this->shop_id['id']);
    }

    public function GetReturnProduct()
    {
        return $this->getReturnProducts($this->shop_id['id']);
    }

    public function GetCompletedProduct()
    {
        return $this->getCompletedProducts($this->shop_id['id']);
    }

}
