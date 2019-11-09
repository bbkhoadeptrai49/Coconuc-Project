<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailsOrder extends Model
{
    protected $fillable = ['details_order_product_id_foreign', 'details_order_oders_id_foreign', 'quantity', 'price'];

    //Table name
    protected $table = 'details_order';

    //Primary key
    protected $primaryKey = 'id';

    //Timestamps
    public $timestamps = false;
}
