<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    public function employee() {
        return $this->belongsTo('App\Employee');
    }

    public function availabilityelements() {
        return $this->hasMany('App\AvailabilityElement');
    }
}