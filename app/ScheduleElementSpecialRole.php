<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ScheduleElementSpecialRole extends Pivot
{
    protected $fillable = [
        'special_role_id','schedule_element_id'
    ];

    public function scheduleelement() {
        return $this->belongsTo('App\ScheduleElement','schedule_element_id');
    }

    public function specialrole() {
        return $this->belongsTo('App\SpecialRole','special_role_id');
    }
}
