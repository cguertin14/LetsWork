<?php

namespace App;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Schedule extends Model
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
        'name','company_id','begin','end','slug'
    ];

    public function company() {
        return $this->belongsTo('App\Company');
    }

    public function scheduleelements() {
        return $this->hasMany('App\ScheduleElement');
    }
}
