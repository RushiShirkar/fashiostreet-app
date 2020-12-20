<?php
/**
 * Created by PhpStorm.
 * User: sagar
 * Date: 6/26/2018
 * Time: 1:56 AM
 */

namespace fashiostreet\throttle;

Use Illuminate\Database\Eloquent\Model;

class ThrottleType extends Model
{
    protected $table = 'ThrottleType';

    public function Throttle()
    {
        return $this->hasMany('fashiostreet\throttle\Throttle');
    }
}
