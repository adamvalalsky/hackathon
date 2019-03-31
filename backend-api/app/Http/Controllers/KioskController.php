<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doctor;
use App\Order;
use App\Patient_doctor;
use App\Patient;
use Carbon\Carbon;

class KioskController extends Controller
{
    public function getNumbers(Request $request, $token){
      $doctor = Doctor::where('token', $token)->firstOrFail();

      $orders = collect();
      foreach($doctor->orders as $order){
        if($order->queue != null){
          $number = [
            'queue' => $order->queue,
            'ordered' => $order->term == null ? false : true
          ];

          $orders->push($number);
        }
      }

      return response([
        'numbers' => $orders
      ], 200);
    }

    public function postOrderedPatient(Request $request, $token, $code){
      $doctor = Doctor::where('token', $token)->first();
      if($doctor == null){
        return response([
          'message' => 'neplatný token'
        ], 403);
      }


      $order = Order::where(['code' => $code, 'queue' => null, 'doctor_id' => $doctor->id])->first();

      if($order == null){
        return response([
          'message' =>'Kód neplatný'
        ], 403);
      }
      $order->queue = Order::getMax($doctor->id);
      $order->code = null;
      $order->active = date('Y-m-d H:i:s');
      $order->update();

      return response([
        'number' => $order->queue
      ]);
    }

    public function postNonOrderedPatient(Request $request, $token){
      $number = $request->number;

      //get doctor
      $doctor = Doctor::where('token', $token)->first();
      if($doctor == null){
        return response([
          'message' => 'neplatný token'
        ], 403);
      }

      //check if patient exists
      $patient = Patient::where('number', $number)->first();
      if($patient == null){
        //create patient with number
        $patient = new Patient();
        $patient->number = $number;
        $patient->name = null;
        $patient->user_id = null;
        $patient->save();

        $patient_id = $patient->id;
      }else{
        $patient_id = $patient->id;
      }


      //check if patient is assigned to doctor
      if(!$patient->has($doctor)){
        //assign patient to doctor
        $pd = new Patient_doctor();
        $pd->patient_id = $patient_id;
        $pd->doctor_id = $doctor->id;
        $pd->save();
      }

      //check if patient is already signed in
      foreach(Order::where('patient_id', $patient_id)->get() as $order){
        if(date('Y-m-d') == date('Y-m-d', strtotime($order->created_at))){
          return response([
            'message' => 'neda sa'
          ], 403);
        }
      }

      $order = new Order();
      $order->patient_id = $patient_id;
      $order->doctor_id = $doctor->id;
      $order->active = date('Y-m-d H:i:s');
      $order->queue = Order::getMax($doctor->id);
      $order->save();

      return response([
        'number' => $order->queue
      ], 200);




    }
}
