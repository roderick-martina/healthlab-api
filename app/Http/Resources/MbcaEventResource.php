<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MbcaEventResource extends JsonResource
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
            'patient_identifier' => $this->identifier,
            'valid_identifier' => $this->patient->valid_identifier,
            'age' => $this->getAge(),
            'gender' => $this->gender,
            'bmi_value' => $this->bmi_value,
        ];
    }
}
