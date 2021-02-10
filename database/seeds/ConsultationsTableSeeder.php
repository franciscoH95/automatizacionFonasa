<?php

use App\Consultation;
use Illuminate\Database\Seeder;

class ConsultationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Consultation::create([
            'number_patients' => 0,
            'specialist_name' => 'Fernando Itza Santos',
            'type_consultation' => 'CGI',
            'state' => 'en espera',
            'hospital_id' => 1
        ]);

        Consultation::create([
            'number_patients' => 0,
            'specialist_name' => 'José María Boada',
            'type_consultation' => 'CGI',
            'state' => 'en espera',
            'hospital_id' => 1
        ]);

        Consultation::create([
            'number_patients' => 0,
            'specialist_name' => 'Belén Martínez-Herrera',
            'type_consultation' => 'Pediatría',
            'state' => 'en espera',
            'hospital_id' => 1
        ]);

        Consultation::create([
            'number_patients' => 0,
            'specialist_name' => 'José Manuel Canales',
            'type_consultation' => 'Urgencia',
            'state' => 'en espera',
            'hospital_id' => 1
        ]);


    }
}
