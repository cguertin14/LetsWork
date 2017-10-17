<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleElement extends Model
{
    protected $table = 'schedule_elements';

    protected $fillable = [
        'begin','end','schedule_id'
    ];

    public function employees() {
        return $this->belongsToMany('App\Employee')->using('App\EmployeeScheduleElement')->withTimestamps();
    }

    public function specialroles() {
        return $this->belongsToMany('App\SpecialRole')->using('App\ScheduleElementSpecialRole')->withTimestamps();
    }

    public function schedule() {
        return $this->belongsTo('App\Schedule');
    }
}