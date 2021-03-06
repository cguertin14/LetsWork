<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class JobOfferUser extends Pivot
{
    protected $fillable = [
        'letter','user_id','job_offer_id','accepted','interview'
    ];

    public function user() {
        return $this->belongsTo('App\User','user_id');
    }

    public function joboffer() {
        return $this->belongsTo('App\JobOffer','job_offer_id');
    }
}
