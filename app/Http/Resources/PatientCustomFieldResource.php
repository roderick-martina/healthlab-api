<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\CustomField;

class PatientCustomFieldResource extends JsonResource
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
            'patient_id' => $this->patient_id,
            'value' => $this->value,
            // 'custom_field_id' => $this->custom_field_id,
            'custom_field' => new CustomFieldResource(CustomField::find($this->custom_field_id)),
            'created_at' => $this->created_at->format('d-m-Y')
        ];
    }
}
