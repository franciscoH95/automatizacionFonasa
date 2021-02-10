<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name', 'age', 'num_medical_history', 'priority', 'risk', 'hospital_id', 'type', 'attended_by', 'state'
    ];

    public function hospital(){
        return $this->belongsTo('App\Hospital');
    }

    public function elder(){
        return $this->hasOne('App\Elder');
    }

    public function young(){
        return $this->hasOne('App\Young');
    }

    public function child(){
        return $this->hasOne('App\Child');
    }
}
