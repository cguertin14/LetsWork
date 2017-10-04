<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SpecialRole extends Model
{
    use Notifiable;
    use Sluggable;
    use SluggableScopeHelpers;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }

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
        return $this->hasMany('App\JobOffer');
    }

    public function roles() {
        return $this->belongsToMany('App\Role')->using('App\SpecialRoleRole')->withTimestamps();
    }

    public function skills() {
        return $this->belongsToMany('App\Skill')->using('App\SkillSpecialRole')->withTimestamps();
    }
}