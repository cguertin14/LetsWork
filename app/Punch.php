<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Punch extends Model
{
	protected $fillable=[
        'datebegin','dateend','employee_id','company_id'
    ];

	public function employee() {
        return $this->belongsTo('App\Employee');
    }

    public function company() {
	    return $this->belongsTo('App\Company');
    }
}
