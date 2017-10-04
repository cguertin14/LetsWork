<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class JobOfferUser extends Pivot
{
    protected $fillable = [
        'letter','user_id','job_offer_id'
    ];
}
