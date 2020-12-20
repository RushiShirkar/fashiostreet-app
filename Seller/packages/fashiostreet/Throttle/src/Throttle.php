<?php
/**
 * Created by PhpStorm.
 * User: sagar
 * Date: 6/25/2018
 * Time: 11:56 PM
 */

namespace fashiostreet\throttle;

Use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Throttle extends Model
{
    use SoftDeletes;

    protected $table = 'Throttle';

    protected $dates = ['deleted_at'];

    public function throttletype()
    {
        return $this->belongsTo('fashiostreet\throttle\ThrottleType');
    }
}
