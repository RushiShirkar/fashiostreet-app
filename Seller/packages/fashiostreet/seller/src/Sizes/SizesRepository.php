<?php
namespace fashiostreet\seller\Sizes;
use fashiostreet\seller\Sizes\SizesTrait as SizesTrait;
trait SizesRepository{
    use SizesTrait;

    protected function updateSizes($product_id,$new_sizes)
    {
        $old_sizes = $this->getsizes($product_id);
        foreach($new_sizes as $key => $value)
        {
            if(array_key_exists($key,$old_sizes))
            {
                $this->updateSizes($product_id,$new_sizes);
            }
            else
            {
                //insert
            }
        }
        foreach ($old_sizes as $key => $value)
        {
            if(!array_key_exists($key,$new_sizes))
            {
                //delete
            }
        }

    }
}
