<?php

namespace fashiostreet\seller\Tabs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use fashiostreet\seller\Tabs\TabsDB as TabsDB;
use FS_Response;
use Validate;

class TabsRepository extends Controller
{
    use TabsDB;

    public function getTabs()
    {
        $tabs = (array) $this->getAll();
        return (count($tabs) > 0) ? FS_Response::success('data',$tabs) : FS_Response::error(500,'No Tabs Found');
    }


    public function addTab(Request $request)
    {
        if(!isset($request->gender)){
            return FS_Response::error(500,'gender parameter missing');
        }
        if(!isset($request->category)){
            return FS_Response::error(500,'category parameter missing');
        }
        if(!isset($request->sub_category)){
            return FS_Response::error(500,'sub_category parameter missing');
        }

        $category_sub_gender = $this->getC_S_G_id($request->gender,$request->category,$request->sub_category);
        $this->add($category_sub_gender);
        return FS_Response::success('message','successfully tab created');

    }

    public function deleteTab(Request $request)
    {
        if(!isset($request->gender)){
            return FS_Response::error(500,'gender parameter missing');
        }
        if(!isset($request->category)){
            return FS_Response::error(500,'category parameter missing');
        }
        if(!isset($request->sub_category)){
            return FS_Response::error(500,'sub_category parameter missing');
        }

        $category_sub_gender = $this->getC_S_G_id($request->gender,$request->category,$request->sub_category);
        $this->delete($category_sub_gender);
        return FS_Response::success('message','successfully tab deleted');
    }

    public function TabsGender_list()
    {
        return FS_Response::success('data',$this->getGender_list());
    }

    public function TabsCategory_list(Request $request)
    {
        if(!isset($request->gender)){
            return FS_Response::error(500,'gender parameter missing');
        }
        return FS_Response::success('data',$this->getCategory_list($request->gender));
    }

    public function TabsSub_Category_list(Request $request)
    {
        if(!isset($request->gender)){
            return FS_Response::error(500,'gender parameter missing');
        }
        if(!isset($request->category)){
            return FS_Response::error(500,'category parameter missing');
        }
        return FS_Response::success('data',$this->getSub_Category_list($request->gender,$request->category));
    }

}
