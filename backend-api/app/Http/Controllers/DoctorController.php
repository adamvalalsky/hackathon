<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doctor;
use App\Order;
use App\Http\Resources\OrderCollection;

class DoctorController extends Controller
{
    public function waitingRoom(Request $request, $token){
      $doctor = Doctor::where('token', $token)->firstOrFail();

      if($doctor == null){
        return response([
          'message' => 'neplatný token'
        ], 403);
      }

      $waiting_room = Order::where('active', '!=', null)->where('doctor_id', $doctor->id)->get();

      $orders = [];
      foreach($waiting_room as $order){

        $o = [
          'id' => $order->id,
          'queue' => $order->queue,
          'active' => $order->active,
          'type' => [
            'id' => $order->job->id,
            'name' =>$order->job->name
          ]
        ];

        $orders[] = $o;
      }

      return $orders;
    }
}
