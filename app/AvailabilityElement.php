<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailabilityElement extends Model
{
    protected $fillable=[
        'begin','end'
    ];

    public function availability() {
        return $this->belongsTo('App\Availability');
    }
}
