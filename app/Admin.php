<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdminResetPasswordNotification;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'one_admins';

    protected $guard ='admin';

    protected $fillable = [
        'name', 'username', 'email', 'role', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    // copied from vendor/laravel/framework/src/Illuminate/Auth/Passwords/CanResetPassword.php
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }

    public function categories()
    {
      return $this->hasMany('App\Category');
    }

}
