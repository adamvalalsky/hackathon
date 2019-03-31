<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DoctorCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $doctors = array();
        foreach($this->collection as $doctor){
          $d = [
          'id' => $doctor->resource->id,
          'name' => $doctor->resource->name,
          'area' => [
            'id' => $doctor->resource->type->id,
            'name' => $doctor->resource->type->name
          ]

        ];

        $doctors[] = $d;
        }

        return $doctors;
    }
}
