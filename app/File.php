<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'user_id','file_type_id','content'
    ];

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