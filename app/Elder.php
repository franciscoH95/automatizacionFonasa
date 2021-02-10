<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Elder extends Model
{
    protected $fillable = [
        'has_a_diet', 'patient_id'
    ];

    public function patients(){
        return $this->belongsTo('App\Patient');
    }
}
