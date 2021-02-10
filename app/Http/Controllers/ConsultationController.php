<?php

namespace App\Http\Controllers;

use App\Consultation;
use App\Patient;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $consultation = Consultation::find($request['consultation']['id']);
        $consultation->state = 'ocupado';
        $consultation->attending_patient = $request['patient']['id'];
        $consultation->number_patients = $consultation->number_patients + 1;
        $consultation->save();

        $patient = Patient::find($request['patient']['id']);
        $patient->attended_by = $request['consultation']['id'];
        $patient->save();

        return $consultation;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getConsultations() {
        $consultations = Consultation::all();
        return $consultations;
    }

    public function fetchConsultation() {
        $consultations = Consultation::all();

        $consultationMorePatients = [];
        $currentMax = 0;

        foreach ($consultations as $consultation) {
            if ($consultation->number_patients >= $currentMax) {
                $currentMax = $consultation->number_patients;
            }
        }

        if ($currentMax > 0) {
            foreach ($consultations as $consultation) {
                if ($currentMax == $consultation->number_patients) {
                    array_push($consultationMorePatients, $consultation);
                }
            }
            return $consultationMorePatients;
        } else {
            return null;
        }
    }

    public function freeConsultation(Request $request) {
        $patient = Patient::find($request['patient_id']);
        $patient->state = 'attended';
        $patient->save();
        
        $consultation = Consultation::find($request['consultation_id']);
        $consultation->state = 'en espera';
        $consultation->attending_patient = 0;
        $consultation->save();
    }
}
