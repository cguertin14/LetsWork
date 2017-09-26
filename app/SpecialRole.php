<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialRole extends Model
{
    protected $fillable = [
        'name','description','company_id'
    ];

    public function employees() {
        return $this->belongsToMany('App\Employee')->using('App\EmployeeSpecialRole')->withTimestamps();
    }

    public function scheduleelementspecialroles() {
        return $this->belongsToMany('App\Employee')->using('App\ScheduleElementSpecialRole')->withTimestamps();
    }

    public function scheduleelements() {
        return $this->belongsToMany('App\ScheduleElement')->using('App\ScheduleElementSpecialRole')->withTimestamps();
    }

    public function joboffers() {
        return $this->belongsToMany('App\JobOffer')->withTimestamps();
    }

    public function roles() {
        return $this->belongsToMany('App\Role')->using('App\SpecialRoleRole')->withTimestamps();
    }

    public function skills() {
        return $this->belongsToMany('App\Skill')->using('App\SkillSpecialRole')->withTimestamps();
    }
}