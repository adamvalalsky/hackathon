<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Doctor;
use App\Order;
use App\Request as Doctor_request;
use App\Http\Resources\DoctorCollection;
use App\Http\Resources\Doctor as DoctorResource;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\Patient as PatientResource;

class PatientController extends Controller
{
    public function getDoctors(Request $request, $id){
      $patient = Patient::findOrFail($id);
      $all_doctors = new DoctorCollection(Doctor::all());
      $current_doctors = new DoctorCollection($patient->doctors);

      return response([
        'all_doctors' => $all_doctors,
        'current_doctors' => $current_doctors
      ], 200);
    }

    public function getCurrentDoctors(Request $request, $id){
      $patient = Patient::findOrFail($id);

      return new DoctorCollection($patient->doctors);


    }

    public function getDoctor(Request $request, $id, $doctor_id){
      $patient = Patient::findOrFail($id);
      $doctor = Doctor::findOrFail($doctor_id);

      return new DoctorResource($doctor);
    }

    public function addDoctor(Request $request, $id, $doctor_id){
      $patient = Patient::findOrFail($id);
      $doctor = Doctor::findOrFail($doctor_id);

      if(!$patient->has($doctor)){
        $dc = new Doctor_request();
        $dc->patient_id = $id;
        $dc->doctor_id = $doctor_id;
        $dc->save();

        return response([
          'message' => 'Žiadosť poslaná'
        ], 200);
      }

      return response([
        'message' => 'Doktor je pridaný alebo na túto akciu nemáte oprávnenie'
      ], 403);
    }

    public function getOrders(Request $request, $id){
      $patient = Patient::findOrFail($id);

      return new OrderCollection($patient->orders);
    }

    public function stepOne(Request $request, $id, $doctor_id){
      //TODO current date
      if($request->has('year')){
        $year = $request->year;
      }else{
        $year = date('Y');
      }

      if($request->has('month')){
        $month = $request->month;
      }else{
        $month = date('m');
      }

      if($request->has('day')){
        $day = $request->day;
      }else{
        $day = date('d');
      }

      $date = date('Y-m-d', strtotime($year.'-'.$month.'-'.$day));

      $doctor = Doctor::findOrFail($doctor_id);
      session(['date' => $date]);

      $terms = $doctor->getTerms($date);

      return response([
        'date' => $date,
        'terms' => $terms
      ], 200);
    }

    public function getCalendar(Request $request, $id, $doctor_id){

      //get month and year
      if($request->has('month')){
        $month = $request->month;
      }else{
        $month = date('m');
      }

      if($request->has('year')){
        $year = $request->year;
      }else{
        $year = date('Y');
      }
      $doctor = Doctor::findOrFail($doctor_id);

      $calendar = $doctor->getCalendar($month, $year);

      return response([
        'id' => $doctor->id,
        'name' => $doctor->name,
        'area' => [
          'id' => $doctor->type->id,
          'name' => $doctor->type->name
        ],
        'month' => $month,
        'text' => $doctor->getTextMonth($month),
        'year' => $year,
        'calendar' => $calendar
      ], 200);

    }

    public function getAvailability(Request $request, $id, $doctor_id, $year, $month, $day){
      $doctor = Doctor::findOrFail($doctor_id);

      $color = $doctor->getAvailable($year, $month, $day);

      return response([
        'color' => $color
      ], 200);

    }

    public function getForm(Request $request, $id, $doctor_id){
      if(!$request->has('term') && !$request->has('date')){
        return response([
          'message' => 'f'
        ], 403);
      }
      $date = date('Y-m-d', strtotime($request->date));
      $term = $request->term;
      $patient = Patient::findOrFail($id);
      $doctor = Doctor::findOrFail($doctor_id);

      $jobs = [];
      foreach($doctor->type->jobs as $job){
        $jobs[] = $job;
      }

      return response([
        'patient' => [
          'id' => $patient->id,
          'name' => $patient->name,
          'number' => $patient->number
        ],
        'doctor' => new DoctorResource($doctor),
        'date' => $date,
        'term' => $term,
        'select' => $jobs
      ], 200);
    }

    public function postOrder(Request $request, $id, $doctor_id){
      $date = $request->date;
      $term = $request->term;
      $type = $request->type;
      $start = explode('-', $term);

      $full = $date.' '.$start[0].':00';
      $code = Doctor::getRandomCode();

      $order = new Order();
      $order->patient_id = $id;
      $order->doctor_id = $doctor_id;
      $order->term = date('Y-m-d H:i:s', strtotime($full));
      $order->type = $type;
      $order->code = $code;
      $order->save();

      return response([
        'code' => $code
      ], 200);

    }
}
