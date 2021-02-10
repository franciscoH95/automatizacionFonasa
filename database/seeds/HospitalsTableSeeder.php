<?php

use App\Hospital;
use Illuminate\Database\Seeder;

class HospitalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hospital::create(['name' => 'Hospital Metropolitano de Santiago']);
    }
}
