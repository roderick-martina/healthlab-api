<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class MbcaResource extends JsonResource
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
            'date_of_birth' => $this->date_of_birth,
            'age' => $this->getAge(),
            'gender' => $this->gender,
            'doctor' => $this->doctor,
            'created' => $this->created,
            'ethnic' => $this->ethnic,
            'last_modified' => $this->last_modified,
            'timestamp' => $this->timestamp,
            'bmi_value' => $this->bmi_value,
            'sds_bmi_value' => $this->sds_bmi_value,
            'percentile_bmi_value' => $this->percentile_bmi_value,
            'relative_fat_mass_value' => $this->relative_fat_mass_value,
            'absolute_fat_mass_value' => $this->absolute_fat_mass_value,
            'fat_free_mass_value' => $this->fat_free_mass_value,
            'skeletal_muscle_mass_value' => $this->skeletal_muscle_mass_value,
            'smm_torso_value' => $this->smm_torso_value,
            'smm_rl_value' => $this->smm_rl_value,
            'smm_ll_value' => $this->smm_ll_value,
            'smm_la_value' => $this->smm_la_value,
            'smm_ra_value' => $this->smm_ra_value,
            'total_body_water_value' => $this->total_body_water_value,
            'extracellular_water_value' => $this->extracellular_water_value,


            'waist_circumference_value' => $this->waist_circumference_value,
            'sds_weight_value' => $this->sds_weight_value,
            'weight_value' => $this->weight_value,
            'percentile_weight_value' => $this->percentile_weight_value,
            'sds_height_value' => $this->sds_height_value,
            'height_value' => $this->height_value,
            'percentile_height_value' => $this->percentile_height_value,
            'total_energy_expenditure_value' => $this->total_energy_expenditure_value,
            'resting_energy_expenditure_value' => $this->resting_energy_expenditure_value,
            'ffmi_value' => $this->ffmi_value,
            'fmi_value' => $this->fmi_value,
            'z_ffmi_value' => $this->z_ffmi_value,
            'z_fmi_value' => $this->z_fmi_value,
            'bioelectric_impedance_vector_analysis_r_value' => $this->bioelectric_impedance_vector_analysis_r_value,
            'bioelectric_impedance_vector_analysis_xc_value' => $this->bioelectric_impedance_vector_analysis_xc_value,
            'bioelectric_impedance_vector_analysis_zr_value' => $this->bioelectric_impedance_vector_analysis_zr_value,
            'bioelectric_impedance_vector_analysis_zxc_value' => $this->bioelectric_impedance_vector_analysis_zxc_value,
            'phaseangle_value' => $this->phaseangle_value,
            'sds_phaseangle_value' => $this->sds_phaseangle_value,
            'percentile_phaseangle_value' => $this->percentile_phaseangle_value,
            'ecw_by_tbw_value' => $this->ecw_by_tbw_value,

       ];
    }
}
