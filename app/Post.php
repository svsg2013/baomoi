<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function category()
    {
    	return $this->belongsTo('App\Category','category_id','id');
    }

    public function tags()
    {
    	return $this->belongsToMany('App\Tag', 'post_tag', 'post_id', 'tag_id');
    }
    public function Admin()
    {
    	return $this->belongsTo('App\Admin','user_id','id');
    }
    public function files()
    {
    	return $this->hasMany('App\File', 'post_id','id');
    }
}
