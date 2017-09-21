<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function punches() {
        return $this->hasMany('App\Punch');
    }

    public function availabilities() {
        return $this->hasMany('App\Availability');
    }

    public function absences() {
        return $this->hasMany('App\Absence');
    }

    public function companies() {
        return $this->belongsToMany('App\Company')->using('App\CompanyEmployee')->withTimestamps();
    }

    public function schedulechange() {
        return $this->hasMany('App\ScheduleChange','employee_to_change_id');
    }

    public function schedulechangereceived() {
        return $this->hasMany('App\ScheduleChange','employee_to_accept_id');
    }

    public function specialroles() {
        return $this->belongsToMany('App\SpecialRole')->using('App\EmployeeSpecialRole')->withTimestamps();
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function scheduleelementspecialroles() {
        return $this->belongsToMany('App\SpecialRole')->using('App\ScheduleElementSpecialRole')->withTimestamps();
    }

    public function scheduleelements() {
        return $this->belongsToMany('App\ScheduleElement')->using('App\ScheduleElementSpecialRole')->withTimestamps();
    }
}