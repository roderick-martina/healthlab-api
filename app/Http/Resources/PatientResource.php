<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\PatientCustomField;

class PatientResource extends JsonResource
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
            'identifier' => $this->identifier,
            'valid_identifier' => $this->valid_identifier,
            'research_project' => $this->research_project,
            'gender' => $this->gender,
            'age' => $this->getAge(),
            'manuel_created' => $this->manuel_created,
            'mbca_results' => MbcaResource::collection($this->mbca),
            'bodpod_results' => BodpodResource::collection($this->bodpod),
            'patient_custom_field' => PatientCustomFieldResource::collection($this->PatientCustomField)
        ];
    }

    // public function with($request)
    // {
    //     return [
    //         'mbca' => $this->mbca,
    //     ];
    // }
}
