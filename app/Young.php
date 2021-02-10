<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Young extends Model
{
    protected $fillable = [
        'is_a_smoker', 'years_smoker', 'patient_id'
    ];

    public function patients(){
        return $this->belongsTo('App\Patient');
    }
}
