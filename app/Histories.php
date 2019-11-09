<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Histories extends Model
{
    protected $fillable = ['histories_order_id_foreign', 'histories_user_id_foreign'];

    //Table name
    protected $table = 'histories';

    //Primary key
    protected $primaryKey = 'id';

    //Timestamps
    public $timestamps = true;
}
