<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class JobOffer extends Model
{
    use Notifiable;
    use Sluggable;
    use SluggableScopeHelpers;

    protected $fillable = [
        'name','description','job_count',
        'company_id','special_role_id'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }

    public function company() {
        return $this->belongsTo('App\Company');
    }

    public function specialrole() {
        return $this->belongsTo('App\SpecialRole','special_role_id');
    }

    public function users() {
        return $this->belongsToMany('App\User')->using('App\JobOfferUser')->withTimestamps()->withPivot('letter','id','accepted','interview');
    }
}
