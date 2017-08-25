<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'one_users';
    //protected $primaryKey = 'username';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'confirmation_code',
    ];

    public function posts()
    {
      return $this->hasMany('App\Post');//I first had an error bc it was App/Post not App\Post!!!
    }

    public function comments()
    {
      return $this->hasMany('App\Comment');
    }

    public function categories()
    {
      return $this->belongsToMany('App\Category', 'one_category_user', 'user_id', 'category_id');
    }
}
