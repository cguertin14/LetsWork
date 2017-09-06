<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function specialroles() {
        return $this->belongsToMany('App\SpecialRole')->using('App\SpecialRoleRole')->withTimestamps();
    }
}
