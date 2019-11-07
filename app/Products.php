<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = ['product_name', 'description', 'price', 'products_user_id_foreign', 'products_type_id_foreign'];

    //Table name
    protected $table = 'products';

    //Primary key
    protected $primaryKey = 'id';

    //Timestamps
    public $timestamps = true;


}
