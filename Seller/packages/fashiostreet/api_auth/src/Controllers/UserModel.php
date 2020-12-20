<?php
namespace fashiostreet\api_auth\Controllers;
use Illuminate\Database\Eloquent\Model;
class UserModel extends Model
{
    protected $table = 'users';
    protected $hidden = [
        'password','deleted_at'
    ];
}
