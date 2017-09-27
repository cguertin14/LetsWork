<?php

namespace App;

use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cviebrock\EloquentSluggable\Sluggable;

class User extends Authenticatable
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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'phone_number','first_name','last_name',
        'slug'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
        return $this->belongsToMany('App\JobOffer')->using('App\JobOfferUser')->withTimestamps();
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
}