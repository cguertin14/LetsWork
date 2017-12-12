<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id'
    ];

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

    public function schedulechangesender() {
        return $this->hasMany('App\ScheduleChange','employee_to_change_id');
    }

    public function schedulechangewith() {
        return $this->hasMany('App\ScheduleChange','employee_to_accept_id');
    }

    public function specialroles() {
        return $this->belongsToMany('App\SpecialRole')->using('App\EmployeeSpecialRole')->withTimestamps();
    }

    public function user() {
        return $this->belongsTo('App\User','user_id');
    }

    public function scheduleelements() {
        return $this->belongsToMany('App\ScheduleElement')->using('App\EmployeeScheduleElement')->withTimestamps();
    }
}