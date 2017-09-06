<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    public function company() {
        return $this->belongsTo('App\Company');
    }

    public function specialrole() {
        return $this->hasOne('App\SpecialRole');
    }

    public function users() {
        return $this->belongsToMany('App\User')->using('App\JobOfferUser')->withTimestamps();
    }
}
