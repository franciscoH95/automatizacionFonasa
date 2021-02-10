<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/newpatient', 'PatientController');

Route::post('/fetchpatients', 'PatientController@fetchPatients');

Route::get('/fetchsmokers', 'PatientController@fetchSmokers');

Route::get('/fetcholderpatient', 'PatientController@fetchOlderPatient');

Route::get('/getconsultations', 'ConsultationController@getConsultations');

Route::get('/getallpatients', 'PatientController@getAllPatients');

Route::get('/fetchconsultation', 'ConsultationController@fetchConsultation');

Route::put('/updateconsultation', 'ConsultationController@update');

Route::put('/freeconsultation', 'ConsultationController@freeConsultation');

Route::get('/gethospitals', 'HospitalController@getHospitals');

Route::get('/getusers', 'UserController@getUsers');

Route::post('/newhospital', 'HospitalController@create');

Route::get('/getroles', 'UserController@getRoles');

Route::post('/newuser', 'UserController@create');