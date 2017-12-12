<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Company extends Model {
	use Sluggable;
	use SluggableScopeHelpers;

	public function sluggable() {
		return [
			'slug' => [
				'source' => 'name',
			],
		];
	}

	public $fillable = [
		'name', 'description', 'telephone', 'email',
		'ville', 'adresse', 'zipcode', 'pays',
		'user_id', 'company_type_id', 'photo',
	];

	public function owner() {
		return $this->belongsTo('App\User', 'user_id');
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

	public function skills() {
		return $this->hasMany('App\Skill');
	}

	public function specialroles() {
		return $this->hasMany('App\SpecialRole');
	}

	public function punches() {
	    return $this->hasMany('App\Punch');
    }
}