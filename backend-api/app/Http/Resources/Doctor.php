<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Doctor extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [[
          'id' => $this->id,
          'name' => $this->name,
          'area' => [
            'id' => $this->type->id,
            'name' => $this->type->name
          ],
        ]];
    }
}
