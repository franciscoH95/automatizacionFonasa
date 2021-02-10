<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $fillable = [
        'name'
    ];

    public function consultations(){
        return $this->hasMany('App\Consultation');
    }

    public function patients(){
        return $this->hasMany('App\Patient');
    }

    public function users(){
        return $this->hasMany('App\User');
    }
}
