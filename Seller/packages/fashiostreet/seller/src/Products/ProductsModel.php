<?php
namespace fashiostreet\seller\Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsModel extends Model
{
    use SoftDeletes;
    protected $table = 'product';
    protected $dates = ['deleted_at'];
}
