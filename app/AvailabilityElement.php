<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailabilityElement extends Model
{
    public function availability() {
        return $this->belongsTo('App\Availability');
    }
}
