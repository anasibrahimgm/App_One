<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'one_categories';

    protected $hidden = [
      'admin_id', 'created_at', 'updated_at', 'pivot',
    ];

    public function admin()
    {
      return $this->belongsTo('App\Admin');
    }

    public function users()
    {
      return $this->belongsToMany('App\User', 'one_category_user', 'category_id', 'user_id');
      //belongsToMany(ModelToLink, IntermediaryTable, ColumnNameForTheCurrentModel, ColumnNameForTheJoiningModel);
    }

    public function posts()
    {
      return $this->hasMany('App\Post');
    }

}
