<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileType extends Model
{
    //
    public function files()
    {
        return $this->hasMany('App\File');
    }
}
