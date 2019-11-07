<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordResets extends Model
{


    protected $table = 'password_resets';

    //Primary key
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = ['email', 'token'];

   

}
