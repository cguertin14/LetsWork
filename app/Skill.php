<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Skill extends Model
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

    public function specialroles() {
        return $this->belongsToMany('App\SpecialRole')->using('App\SkillSpecialRole')->withTimestamps();
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }
}
