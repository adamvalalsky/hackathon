<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Patient_doctor;

class Patient extends Model
{
    public function doctors(){
      return $this->belongsToMany(Doctor::class, 'patient_doctors');
    }

    public function user(){
      return $this->belongsTo(User::class);
    }

    public function orders(){
      return $this->hasMany(Order::class);
    }
    
    public function has($doctor){
      if(count(Patient_doctor::where(['patient_id' => $this->id, 'doctor_id' => $doctor->id])->get()) > 0){
        return true;
      }

      return false;
    }
}
