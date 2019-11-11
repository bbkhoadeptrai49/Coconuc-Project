<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = ['orders_user_id_foreign', 'coupon', 'adresss', 'costs', 'note'];

    //Table name
    protected $table = 'orders';

    //Primary key
    protected $primaryKey = 'id';

    //Timestamps
    public $timestamps = true;

  
}
