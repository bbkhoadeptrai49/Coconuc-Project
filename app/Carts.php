<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    //Table name
    protected $table = 'carts';

    //Primary key
    protected $primaryKey = 'id';

    //Timestamps
    public $timestamps = false;
}
