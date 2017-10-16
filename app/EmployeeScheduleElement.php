<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EmployeeScheduleElement extends Pivot
{
    protected $fillable = [
        'employee_id','schedule_element_id'
    ];

    protected $table = 'employee_schedule_element';

    public function employee() {
        return $this->belongsTo('App\Employee','employee_id');
    }

    public function scheduleelement() {
        return $this->belongsTo('App\ScheduleElement','schedule_element_id');
    }
}
