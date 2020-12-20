<?php
namespace fashiostreet\throttle\Traits;

use Carbon\Carbon;
use fashiostreet\throttle\Throttle;
use Illuminate\Http\Request;

trait ThrottleTrait
{
    protected $Throttle =5;     //throttle count allow

    public function getIp()
    {
        return \Request::ip();
    }

    public function create($data)
    {

            $throttle = new Throttle();
            $throttle->throttletype_id = $data->throttletype;
            $throttle->ip = $this->getIp();
            if($data->users_id != null)
            {
                $throttle->users_id = $data->users_id;
            }
            return $throttle->save()?:false;
    }

    public function remove($data)
    {

            $throttle = Throttle::where([
                'throttletype_id' => $data->throttletype,
                'users_id' => $data->users_id
            ])
                ->whereDate('created_at', Carbon::today())
                ->delete();
            return $throttle ?: false;

    }

    public function count($data)
    {

            return Throttle::where([
                'throttletype_id' => $data->throttletype,
                'users_id' => $data->users_id
            ])
                ->whereDate('created_at', Carbon::today())
                ->count();

    }

    public function isBlock($data)
    {
        $count = $this->count($data);
        if($count > $this->Throttle)
        {
            return true;
        }
        return false;
    }

}
