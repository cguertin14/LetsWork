<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ScheduleElement extends Model
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

    protected $table = 'schedule_elements';

    protected $fillable = [
        'begin','end','schedule_id','name','description','slug'
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