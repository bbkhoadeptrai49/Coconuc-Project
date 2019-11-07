<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Types extends Model
{
     use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type_name', 'types_categories_id_foreign'];


    //Table name
    protected $table = 'types';

    //Primary key
    protected $primaryKey = 'id';

    //Timestamps
    public $timestamps = true;

    public function category(){
    	return $this->belongsTo('Categories', 'id', 'types_categories_id_foreign');
    }

}
