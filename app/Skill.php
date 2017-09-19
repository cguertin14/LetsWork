<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public function specialroles() {
        return $this->belongsToMany('App\SpecialRole')->using('App\SkillSpecialRole')->withTimestamps();
    }
}
