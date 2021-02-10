<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    protected $fillable = [
        'weight_height', 'patient_id'
    ];

    public function patients(){
        return $this->belongsTo('App\Patient');
    }
}
