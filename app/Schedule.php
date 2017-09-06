<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function company() {
        return $this->belongsTo('App\Company');
    }

    public function scheduleelements() {
        return $this->hasMany('App\ScheduleElement');
    }
}
