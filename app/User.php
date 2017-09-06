<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function notifications() {
        return $this->belongsToMany('App\Notification')->using('App\NotificationUser')->withTimestamps();
    }

    public function messages() {
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

}