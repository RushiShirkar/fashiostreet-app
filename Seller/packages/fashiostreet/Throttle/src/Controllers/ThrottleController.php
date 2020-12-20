<?php
/**
 * Created by PhpStorm.
 * User: sagar
 * Date: 6/25/2018
 * Time: 11:51 PM
 */
namespace fashiostreet\throttle\Controllers;

use App\Http\Controllers\Controller;
use fashiostreet\throttle\ThrottleType;
use fashiostreet\throttle\Traits\ThrottleTrait;
use Illuminate\Http\Request;

class ThrottleController extends Controller
{
    use ThrottleTrait;

    protected $message = 'User reaches today access limit : ';

    protected function getData($type,$user)
    {
        $type = ThrottleType::where('name',$type)->first();
        return $data = (object)[
            'throttletype' => $type->id,
            'users_id' => $user->id
        ];
    }

    public function requesttesting(Request $request)
    {
        $user = [
            'id' => 107
        ];
        $user = json_decode(json_encode((object) $user), FALSE);
        return $this->removeExpire($request->type,$user);
    }

    public function CreateThrottle($type,$user = null)
    {
        if(!$this->create($this->getData($type,$user)))
        {
            throw new \fashiostreet\throttle\Exceptions\ThrottleException('error found');
        }
        return 'successfully throttle created';
    }

    public function isThrottle($type,$user,$message = null)
    {
        if($this->isBlock($this->getData($type,$user)))
        {
            if($message == null)
                $message = $this->message.' '.$type;
            throw new \fashiostreet\throttle\Exceptions\ThrottleException($message);
        }
        return false;
    }

    public function removeExpire($type,$user)
    {
        return $this->remove($this->getData($type,$user));
    }

    
}
