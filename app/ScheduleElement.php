<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleElement extends Model
{
    public function employees() {
        return $this->belongsToMany('App\ScheduleElement')->using('App\ScheduleElementSpecialRole')->withTimestamps();
    }

    public function specialrole() {
        return $this->hasOne('App\SpecialRole');
    }

    public function schedule() {
        return $this->belongsTo('App\Schedule');
    }
}