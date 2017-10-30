<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function company() {
        return $this->belongsTo('App\Company');
    }

    public function files() {
        return $this->belongsToMany('App\File')->using('App\PostFile')->withTimestamps();
    }
}
