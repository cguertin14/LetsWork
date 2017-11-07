<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    protected $fillable = [
      'begin','end','employee_id','reason'
    ];
    public function employee() {
        return $this->belongsTo('App\Employee');
    }
}
