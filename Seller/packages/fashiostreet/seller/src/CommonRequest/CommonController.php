<?php
namespace fashiostreet\seller\Common ;
use App\Http\Controllers\Controller;
use fashiostreet\seller\Common\CommonRepository as CommonRepository;
use FS_Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller{
    use CommonRepository;
    public function getColors()
    {
        return FS_Response::success('data',$this->getColors_list());
    }

    public function getBrands()
    {
        return FS_Response::success('data',$this->getBrands_list());
    }

    public function getTypes()
    {
        return FS_Response::success('data',$this->getTypes_list());
    }

    public function getSizes(Request $request)
    {
       //return FS_Response::success('data',DB::select('select size.name as size from size'));
        $c_s_g_id = $this->getC_S_G_id($request->gender,$request->category,$request->sub_category);
        return FS_Response::success('data',$this->getSizes_list($c_s_g_id));
    }
}
