<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Container\Container;
use Auth;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone', 'sex', 'birthday', 'url_images'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function createToken($name, array $scopes = [])
    // {
    //     return Container::getInstance()->make(PersonalAccessTokenFactory::class)->make(
    //         $this->getKey(), $name, $scopes
    //     );
    // }

    public function isAdmin(){
        return $this->email === 'admin@gmail.com';
    }

    public function product(){
        return $this->hasMany('App\Products','types_user_id_foreign','id');
    }
}
