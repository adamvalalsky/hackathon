<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function patient(){
      return $this->belongsTo(Patient::class);
    }

    public function doctor(){
      return $this->belongsTo(Doctor::class);
    }

    public function job(){
      return $this->belongsTo(Doctor_job::class, 'type', 'id');
    }

    public static function getMax($doctor_id){
      $order = static::where('doctor_id', $doctor_id)->max('queue');

      return (int) $order + 1;
    }
}
