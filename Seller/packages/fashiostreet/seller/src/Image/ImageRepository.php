<?php
namespace fashiostreet\seller\Image;
use App\Jobs\CompressImage;
use fashiostreet\seller\Exceptions\ErrorException;
use fashiostreet\seller\Exceptions\SellerException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Image;
class ImageRepository{

    protected $image_name;
    protected $base64Image;
    protected $extension;

    protected $uploadDir = array(
        array(
            'folder' => 'compress220X258',
	    'width' => null,
            'height' => 658,
		  'compress' => 30
        ),
        array(
            'folder' => 'compress420X458',
	    'width' => null,
            'height' => 958,
		  'compress' => 30
        ),
        array(
            'folder' => 'compress620X658',
	    'width' => null,
            'height' => 1258,
	    'compress' => 80
        )

    );   //product dir

    protected $uploadDir1 = array(
	array(
		'folder' => 'compress420X458'
	),
	array(
		'folder' => 'compress620X658'
	)
    );

    public function uploadProductImage($base64Image,$image_name,$extension)
    {
        $this->base64Image = $base64Image;
        $this->image_name  = $image_name;
        $this->extension = 'jpg';
        $this->ValidateAndUpload();
        for($i=0;$i < count($this->uploadDir);$i++)
        {
            $image = array(
                "name" => $image_name,
                "path1" => base_path().'/public/products/original/',
                "path" => base_path().'/public/products/'.$this->uploadDir[$i]['folder'].'/',
		        "width" => $this->uploadDir[$i]['width'],
                "height" => $this->uploadDir[$i]['height'],
                "compress_ratio" => $this->uploadDir[$i]['compress']
            );
            $img = Image::make($image['path1'].''.$image['name'])->resize($image['width'],$image['height'],function($constraint) { $constraint->aspectRatio(); });
            //return $img;
            $img->save($image['path'].''.$image['name'],$image['compress_ratio']);
            //CompressImage::dispatch($image)->delay(now()->addMinutes(2));
        }
        return true;
    }

    public function uploadShopImage(Request $request,$image_name)
    {
        $this->image_name = $image_name;
        $this->ValidateAndUpload($request);
        $image = array(
            "name" => $image_name,
            "path1" => base_path().'/public/shops/original/',
            "path" => base_path().'/public/shops/compress/',
            "width" => 220,
            "height" => 258,
            "compress_ratio" => 60
        );
        CompressImage::dispatch($image)->delay(now()->addMinutes(2));
        return true;
    }

    public function upload(){
        $path = public_path() . "/products/original/" . $this->image_name;
        $img = substr($this->base64Image, strpos($this->base64Image, ",")+1);
        $data = base64_decode($img);
        $success = file_put_contents($path, $data);
        if($success)
        {
            return true;
        }
        throw new SellerException('!Error while uploading');
    }

    public function ValidateAndUpload()
    {
        $size = (int) (strlen(rtrim($this->base64Image, '=')) * 3 / 4);
        $size    = $size / 1024;
        if($size < 7000)
        {
            return $this->upload();
        }
        throw new ErrorException('!Image size should not be greater than 7MB');
    }

    public function CreateImageName($extension,$image_name)
    {
        $extension = $extension;
        /*$timestamp = date_create();
        $timestamp = date_timestamp_get($timestamp);*/
        $image_name = str_replace(" ","-",$image_name);
        return $image_name . '-' . time() .'-'. rand() .'-'. rand() .'.' . $extension;
    }

    public function DeleteProductOriginalImage($image_name){
        $image_name = explode(",",$image_name);
        for($i=0;$i < count($image_name);$i++)
        {
            $image[$i] = base_path().'/public/products/original/'.$image_name[$i];
            if(File::exists($image[$i]))
            {
                File::delete($image[$i]);
            }
        }
        for($i=0;$i < count($image_name);$i++)
        {
            $image[$i] = base_path().'/public/products/compress220X258/'.$image_name[$i];
            if(File::exists($image[$i]))
            {
                File::delete($image[$i]);
            }
        }
        for($i=0;$i < count($image_name);$i++)
        {
            $image[$i] = base_path().'/public/products/compress420X458/'.$image_name[$i];
            if(File::exists($image[$i]))
            {
                File::delete($image[$i]);
            }
        }
        for($i=0;$i < count($image_name);$i++)
        {
            $image[$i] = base_path().'/public/products/compress620X658/'.$image_name[$i];
            if(File::exists($image[$i]))
            {
                File::delete($image[$i]);
            }
        }
        return true;
    }

    public function DeleteAllProductImages($image_name)
    {
        File::delete(base_path().'/public/products/original/'.$image_name);
        for($i=0;$i < count($this->uploadDir1);$i++)
        {
           File::delete(base_path().'/public/products/'.$this->uploadDir1[$i]['folder'].'/'.$image_name);    
	}
        return true;
    }

}
