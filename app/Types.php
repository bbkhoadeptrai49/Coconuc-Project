<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Types extends Model
{
   
    protected $fillable = ['type_name', 'types_categories_id_foreign'];


    //Table name
    protected $table = 'types';

    //Primary key
    protected $primaryKey = 'id';

    //Timestamps
    public $timestamps = false;

    public function category(){
    	return $this->belongsTo('App\Categories', 'types_categories_id_foreign', 'id');
    }

    public function product(){
        return $this->hasMany('App\Product','products_type_id_foreign', 'id');
    }
}
