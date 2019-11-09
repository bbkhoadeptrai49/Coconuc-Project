<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_name'];


    //Table name
    protected $table = 'categories';

    //Primary key
    protected $primaryKey = 'id';

    //Timestamps
    public $timestamps = false;

    public function type(){
        return $this->hasMany('App\Categories','types_categories_id_foreign','id');
    }

    public function products()
    {
        return $this->hasManyThrough('App\Products', 'App\Types', 'types_categories_id_foreign', 'products_type_id_foreign', 'id');
    }
}
