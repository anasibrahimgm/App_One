<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'one_posts';

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function comments()
    {
      return $this->hasMany('App\Comment');
    }

    public function category()
    {
      return $this->belongsTo('App\Category');
    }
}
