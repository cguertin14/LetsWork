<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'source','user_id'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
