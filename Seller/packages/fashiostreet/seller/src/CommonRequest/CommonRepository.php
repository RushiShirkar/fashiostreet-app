<?php
namespace fashiostreet\seller\Common;
use fashiostreet\seller\Exceptions\ErrorException;
use fashiostreet\seller\Exceptions\SellerException;
use Illuminate\Support\Facades\DB;
use Validate;
use FS_Response;
trait CommonRepository {

    public function getC_S_G_id($gender,$category,$sub_category)
    {

            $c_s_g_id = (array) DB::select('CALL Get_Category_Sub_Gender_id(?,?,?)',[$gender,$category,$sub_category]);
            if(count($c_s_g_id) <= 0)
            {
                throw new ErrorException('Invalid Parameter Value Found');
            }
            return $c_s_g_id[0]->id;
    }

    public function getCity_id($city)
    {
        $city = (array) DB::select('select city.id as id from city where city.name = ?', [$city]);
        if(count($city) <= 0)
        {
            throw new ErrorException('we are not available in this city');
        }
        return $city[0]->id;
    }

    public function getBrand_id($brand)
    {
        $brand = (array) DB::select('select brand.id as id from brand where brand.name = ?',[$brand]);
        if(count($brand) <= 0)
        {
            throw new ErrorException('sorry,brand not register at fashiostreet');
        }
        return $brand[0]->id;
    }

    public function getSize_id($size)
    {
        $size = (array) DB::select('select size.id as id from size where size.name = ?',[$size]);
        if(count($size) <= 0)
        {
            throw new ErrorException('sorry,size not found at fashiostreet');
        }
        return $size[0]->id;

    }
    public function getColor_id($color)
    {
        $color = (array) DB::select('select color.id as id from color where color.name = ?',[$color]);
        if(count($color) <= 0)
        {
            throw new ErrorException('sorry,color not found at fashiostreet');
        }
        return $color[0]->id;
    }

    public function getType_id($type)
    {
        $type = (array) DB::select('select `type`.id as id from `type` where `type`.name = ?',[$type]);
        if(count($type) <= 0)
        {
            throw new ErrorException('sorry,type not found at fashiostreet');
        }
        return $type[0]->id;
    }

    public function getGender_list()
    {
        $gender = (array) DB::select('select name from gender');
        if(count($gender) <= 0)
        {
            throw new SellerException('No gender found');
        }
        return $gender;
    }

    public function getCategory_list($gender)
    {
            $category = (array) DB::select('select DISTINCT (category.name) from category left join category_sub_gender on category_sub_gender.category_id = category.id  left join gender on gender.id = category_sub_gender.gender_id where gender.name = ?',[$gender]);
            if(count($category) <= 0)
            {
                throw new SellerException('No category found of gender '.$gender);
            }
            return $category;
    }

    public function getSub_Category_list($gender,$category)
    {

            $sub_category = (array) DB::select('select DISTINCT (sub_category.name) from category_sub_gender left join gender on gender.id = category_sub_gender.gender_id left join category on category.id = category_sub_gender.category_id left join sub_category on sub_category.id = category_sub_gender.sub_category_id where gender.name = ? and category.name = ?',[$gender,$category]);
            if(count($sub_category) <= 0)
            {
                throw new SellerException('No sub_category found of category '.$category);
            }
            return $sub_category;
    }

    public function getColors_list()
    {
        $colors = (array) DB::select('select color.name as color,color.code as code from color');
        if(count($colors) <= 0)
        {
            throw new ErrorException('no color found');
        }
        return $colors;
    }

    public function getBrands_list()
    {
        $brands = (array) DB::select('select brand.name as brand,brand.image as image from brand');
        if(count($brands) <= 0)
        {
            throw new ErrorException('no brand found');
        }
        return $brands;
    }

    public function getTypes_list()
    {
        $types = (array) DB::select('select type.name as name from type');
        if(count($types) <= 0)
        {
            throw new ErrorException('no types found');
        }
        return $types;
    }

    public function getSizes_list($c_s_g_id)
    {
        $sizes = (array) DB::select('select size.name as size from `sub_category_size` left join size on size.id = sub_category_size.size_id where category_sub_gender_id = ?',[$c_s_g_id]);
        if(count($sizes) <= 0)
        {
            throw new ErrorException('no sizes found');
        }
        return $sizes;
    }

    protected function withError($callback)
    {
        try
        {
            return $callback();
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            throw new SellerException('Tabs,server error please try again or contact or customer service');
        }
    }
}
