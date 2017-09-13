<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name','description','user_id','company_type_id'];

    public function owner() {
        return $this->belongsTo('App\User');
    }

    public function posts() {
        return $this->hasMany('App\Post');
    }

    public function employees() {
        return $this->belongsToMany('App\Employee')->using('App\CompanyEmployee')->withTimestamps();
    }

    public function companytype() {
        return $this->hasOne('App\CompanyType');
    }

    public function schedules() {
        return $this->hasMany('App\Schedule');
    }

    public function joboffers() {
        return $this->hasMany('App\JobOffer');
    }
}