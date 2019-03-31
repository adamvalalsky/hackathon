<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Doctor as DoctorResource;
use App\Http\Resources\Patient as PatientResource;

class Order extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'id' => $this->id,
          'code' => $this->code,
          'term' => $this->term,
          'type' => [
            'id' => $this->job->id,
            'name' => $this->job->name
          ],
          'doctor' => new DoctorResource($this->doctor),
          'patient' => new PatientResource($this->patient),

        ];
    }
}
