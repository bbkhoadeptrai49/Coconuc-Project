<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shops extends Model
{
    protected $fillable = ['shop_name', 'shops_user_id_foreign', 'quantity'];

    //Table name
    protected $table = 'shops';

    //Primary key
    protected $primaryKey = 'id';

    //Timestamps
    public $timestamps = true;
}
