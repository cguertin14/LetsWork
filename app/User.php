<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject {
	use Notifiable;
	use Sluggable;
	use SluggableScopeHelpers;

	public function sluggable() {
		return [
			'slug' => [
				'source' => 'name',
			],
		];
	}

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
		'phone_number', 'first_name', 'last_name',
		'slug', 'cv','facebook_id'
	];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','cv'
    ];

	public function getFullNameAttribute() {
		return $this->first_name . " " . $this->last_name;
	}

	public function notifications() {
		return $this->belongsToMany('App\Notification')->using('App\NotificationUser')->withTimestamps();
	}

	public function sentmessages() {
		return $this->hasMany('App\Messages');
	}
	public function receivedmessages() {
		return $this->hasMany('App\Messages');
	}

	public function joboffers() {
		return $this->belongsToMany('App\JobOffer')->using('App\JobOfferUser')->withTimestamps()->withPivot('letter', 'id', 'accepted', 'interview');
	}

	public function employees() {
		return $this->hasMany('App\Employee');
	}

	public function companies() {
		return $this->hasMany('App\Company');
	}

	public function admin() {
		return $this->belongsTo('App\User');
	}

	public function files() {
		return $this->hasMany('App\File');
	}

	public function photo() {
		return $this->hasOne('App\Photo');
	}

	public function isOwner() {
		if (Session::has('CurrentCompany')) {
			return session('CurrentCompany')->user_id === $this->id;
		} else {
			return false;
		}
	}

	public function session() {
		return $this->hasOne('App\Session');
	}
}