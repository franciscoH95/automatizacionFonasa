<?php

namespace App\Http\Controllers;

use App\Child;
use App\Elder;
use App\Patient;
use App\Young;
use Illuminate\Http\Request;

class PatientController extends Controller
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
    public function create(Request $request)
    {
        


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $patient = Patient::create([
            'name' => $request['name'],
            'age' => $request['age'],
            'num_medical_history' => $request['num_medical_history'],
            'priority' => $request['priority'],
            'risk' => $request['risk'],
            'type' => $request['type_patient'],
            'hospital_id' => $request['hospital_id'],
        ]);

        if ($request['type_patient'] == "child") {
            $p_child = Child::create([
                'weight_height' => $request['weight_height'],
                'patient_id' => $patient->id
            ]);
        }

        if ($request['type_patient'] == "young") {
            $p_young = Young::create([
                'is_a_smoker' => $request['is_a_smoker'],
                'years_smoker' => $request['years_smoker'],
                'patient_id' => $patient->id
            ]);
        }

        if ($request['type_patient'] == "elder") {
            $p_elder = Elder::create([
                'has_a_diet' => $request['has_a_diet'],
                'patient_id' => $patient->id
            ]);
        }

        

        return "ok";
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
    public function update(Request $request, $id)
    {
        //
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

    public function fetchPatients(Request $request) {
        $patients = Patient::all();
        $fetchedPatient = null;
        $allPatients = [];
        foreach ($patients as $patient) {
            if ($patient->num_medical_history == $request['value']) {
                $fetchedPatient = $patient;
            } else {
                array_push($allPatients, $patient);
            }
        }

        $response = ['allPatients' => $allPatients, 'fetchedPatient' => $fetchedPatient];

        return $response;
    }

    public function fetchSmokers() {
        $smokers = Young::where('is_a_smoker', 1)->get();
        $patients = [];
        foreach ($smokers as $smoker) {
            $patient = Patient::find($smoker->patient_id);
            if ($patient->attended_by == 0) {
                array_push($patients, ['category' => $smoker, 'patient' => $patient]);
            }
        }
        return $patients;
    }

    public function fetchOlderPatient() {
        $patients = Patient::all();
        $array_patients = [];
        $older_patients = [];
        $currentMax = 0;

        foreach ($patients as $patient) {
            if ($patient->attended_by == 0) {
                array_push($array_patients, $patient);
            }
        }

        foreach ($array_patients as $patient) {
            if ($patient->age >= $currentMax) {
                $currentMax = $patient->age;
            }
        }

        foreach ($array_patients as $patient) {
            if ($currentMax == $patient->age) {
                array_push($older_patients, $patient);
            }
        }

        return $older_patients;
    }

    public function getAllPatients() {
        $patients = Patient::all();
        return $patients;
    }
}
