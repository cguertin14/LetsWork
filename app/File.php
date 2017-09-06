<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function filetype() {
        return $this->belongsTo('App\FileType');
    }

    public function post() {
        return $this->belongsTo('App\Post');
    }

    public function owner() {
        return $this->belongsTo('App\User');
    }

    public function message() {
        return $this->belongsTo('App\Message');
    }
}