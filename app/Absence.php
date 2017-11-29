<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'reason',
            ]
        ];
    }

    protected $fillable = [
      'begin','end','employee_id','reason'
    ];
    public function employee() {
        return $this->belongsTo('App\Employee');
    }
}
