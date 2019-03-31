<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor_type extends Model
{
    protected $table = 'doctor_types';
    public $timestamps = false;

    public function jobs(){
      return $this->hasMany(Doctor_job::class, 'type_id');
    }
}
