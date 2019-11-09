<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    //Table name
    protected $fillable = ['url'];
    
    protected $table = 'images';

    //Primary key
    protected $primaryKey = 'id';

    //Timestamps
    public $timestamps = true;
}
