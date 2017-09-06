<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //
    public function filetype()
    {
        return $this->hasOne('App\FileType');
    }

    public function owner()
    {
        return $this->hasOne('App\User');
    }
}
