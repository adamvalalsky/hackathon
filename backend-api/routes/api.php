<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('login', 'MainController@postLogin')->name('post.login');

Route::group(['prefix' => 'kiosk/{token}', 'middleware' => 'cors'], function(){
    Route::get('numbers', 'KioskController@getNumbers')->name('kiosk.numbers');
    Route::get('patient/ordered/{code}', 'KioskController@postOrderedPatient')->name('kiosk.ordered');
    Route::post('patient/nonordered', 'KioskController@postNonOrderedPatient')->name('kiosk.nonordered');
});


Route::group(['prefix' => 'patient', 'middleware' => 'cors'], function(){
  //doctors
  Route::get('{id}/doctors', 'PatientController@getDoctors');
  Route::get('{id}/doctors/current', 'PatientController@getCurrentDoctors');
  Route::get('{id}/doctor/{doctor_id}', 'PatientController@getDoctor');
  Route::post('{id}/add/{doctor_id}', 'PatientController@addDoctor');
  Route::get('{id}/doctor/{doctor_id}/current', 'PatientController@getCalendar');
  Route::get('{id}/doctor/{doctor_id}/available/{year}/{month}/{day}', 'PatientController@getAvailability');

  //orders
  Route::get('{id}/orders', 'PatientController@getOrders');
  Route::get('{id}/doctor/{doctor_id}/step_one', 'PatientController@stepOne');
  Route::get('{id}/doctor/{doctor_id}/form', 'PatientController@getForm');
  Route::post('{id}/doctor/{doctor_id}/order', 'PatientController@postOrder');
});

Route::group(['prefix' => 'doctor', 'middleware' => 'cors'], function(){
  Route::get('{token}/waiting_room', 'DoctorController@waitingRoom');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
