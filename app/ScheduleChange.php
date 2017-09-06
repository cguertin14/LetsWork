<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleChange extends Model
{
    public function employee() {
        return $this->belongsTo('App\Employee','employee_to_change_id');
    }

    public function employeeasked() {
        return $this->belongsTo('App\Employee','employee_to_accept_id');
    }
}
