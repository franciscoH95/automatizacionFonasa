<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'number_patients', 'specialist_name', 'type_consultation', 'state', 'hospital_id', 'attending_patient'
    ];

    public function hospital(){
        return $this->belongsTo('App\Hospital');
    }
}
