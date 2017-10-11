<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ScheduleElementSpecialRole extends Pivot
{
    public function scheduleelement() {
        return $this->belongsTo('App\ScheduleElement','schedule_element_id');
    }

    public function specialrole() {
        return $this->belongsTo('App\SpecialRole','special_role_id');
    }

    public function employee() {
        return $this->belongsTo('App\Employee','employee_id');
    }
}
