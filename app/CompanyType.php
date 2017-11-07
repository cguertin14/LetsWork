<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyType extends Model
{
    public function company() {
        return $this->belongsToMany('App\Company')->withTimestamps();;
    }
}
