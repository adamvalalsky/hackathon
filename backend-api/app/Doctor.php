<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Vacation;
use App\Opening_hour;

class Doctor extends Model
{
    public function patients(){
      return $this->belongsToMany(Patient::class, 'patient_doctors');
    }

    public function user(){
      return $this->belongsTo(User::class);
    }

    public function type(){
      return $this->belongsTo(Doctor_type::class, 'area', 'id');
    }

    public function orders(){
      return $this->hasMany(Order::class);
    }

    public function getCalendar($month, $year){

      $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
      $calendar = [];



      for($i = 1; $i <= $days; $i++){
        $day = $year.'-'.$month.'-'.$i;

        if(count(Vacation::where(['doctor_id' => $this->id, 'day' => $day])->get()) > 0 || date('Y-m-d', strtotime($day)) <= date('Y-m-d')){
          $color = 'grey';
        }elseif($this->usedSlots($day) == $this->availableSlots($day)){
          $color = 'red';
        }else{
          $color = 'green';
        }

        $calendar[] = [
          'day' => $i,
          'color' => $color,
          'text' => date('l', strtotime($day))
        ];
      }

      return $calendar;
    }

    public function availableSlots($day){
      $d = date('l', strtotime($day));

      $opening_hour = Opening_hour::where(['doctor_id' => $this->id, 'day' => strtolower($d)])->first();
      if($opening_hour != null){

          //user has end and start
          $start = date_create($opening_hour->start);
          $end = date_create($opening_hour->end);


          $diff = date_diff($end, $start);
          $time = $diff->h*60 + $diff->m;
          $slots = $time/30;

          return $slots;
        }else{
          $date1 = date_create('15:00');
          $date2 = date_create('7:00');

          $diff = date_diff($date1, $date2);
          $time = $diff->h*60 + $diff->m;
          $slots = $time/30;

          return $slots;
        }
    }

    public function getTerms($date){
      $slots = $this->availableSlots($date);
      $start = $this->getHours($date)[0];
      $end = $this->getHours($date)[1];

      $terms = [];
      $start = $date.' '.$start.':00';
      $current_time = $start;
      for($i = 0; $i < $slots; $i++){
        $time = strtotime($current_time);
        $start_time = date('H:i', strtotime('+0 minutes', $time));
        $end_time = date('H:i', strtotime('+30 minutes', $time));

        $current_time = $end_time;
        $x = $start_time.'-'.$end_time;
        $cd = date('Y-m-d H:i:s', strtotime($date.' '.$start_time.':00'));

        $order = Order::where(['term' => $cd, 'doctor_id' => $this->id])->first();
        $terms[] = [
          'term' => $x,
          'available' => $order == null ? true : false
        ];
      }

      return $terms;


    }

    public function usedSlots($date){
      $i = 0;
      foreach($this->orders as $order){
        if(date('Y-m-d', strtotime($date)) == date('Y-m-d', strtotime($order->term))){
          $i++;
        }
      }

      return $i;
    }

    public function getHours($date){
      $d = date('l', strtotime($date));

      $opening_hour = Opening_hour::where(['doctor_id' => $this->id, 'day' => strtolower($d)])->first();
      if($opening_hour != null){
          return [$opening_hour->start, $opening_hour->end];
        }else{
          return ['7:00', '15:00'];
        }
    }

    public function getAvailable($year, $month,  $day){

        $day = $year.'-'.$month.'-'.$day;

        if(count(Vacation::where(['doctor_id' => $this->id, 'day' => $day])->get()) > 0 || date('Y-m-d', strtotime($day)) <= date('Y-m-d')){
          $color = 'grey';
        }elseif($this->usedSlots($day) == $this->availableSlots($day)){
          $color = 'red';
        }else{
          $color = 'green';
        }

        return $color;

    }

    public static function getRandomCode($length = 8){
          $characters = '0123456789';
          $charactersLength = strlen($characters);
          $randomString = '';
          for ($i = 0; $i < $length; $i++) {
              $randomString .= $characters[rand(0, $charactersLength - 1)];
          }
          return $randomString;

    }

    public function getTextMonth($month){
      setlocale(LC_ALL, 'sk_SK');

      $dateObj = \DateTime::createFromFormat('!m', $month);
      $string_time = $dateObj->format('Y-m-d H:i:s');
      //for hosting
      //$this->name = utf8_encode(strftime('%B', strtotime($string_time)));
      //for local dev
      return strftime('%B', strtotime($string_time));

    }
}
