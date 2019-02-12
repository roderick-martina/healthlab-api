<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BodpodResource extends JsonResource
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
            // 'identifier' => $this->patient != null ? $this->patient->identifier : null,
            'user_id' => $this->user_id,
            'test_date' => $this->test_date,
            'age' => (int) $this->age,
            'gender' => $this->gender,
            'height_cm' => $this->height_cm,
            'height_in' => $this->height_in,
            'id_1' => $this->id_1,
            'id_2' => $this->id_2,
            'ethnicity' => $this->ethnicity,
            'operator' => $this->operator,
            'test_no' => $this->test_no,
            'density_model' => $this->density_model,
            'tgv_model' => $this->tgv_model,
            'fat_percentage' => $this->fat_percentage,
            'ffm_percentage' => $this->ffm_percentage,
            'fat_mass_kg' => $this->fat_mass_kg,
            'fat_mass_lb' => $this->fat_mass_lb,
            'fat_free_mass_kg' => $this->fat_free_mass_kg,
            'fat_free_mass_lb' => $this->fat_free_mass_lb,
            'body_mass_kg' => $this->body_mass_kg,
            'body_mass_lb' => $this->body_mass_lb,
            'estimate_rmr_kcal_day' => $this->estimate_rmr_kcal_day,
            'estimate_tee_kcal_day' => $this->estimate_tee_kcal_day,
            'activity_level' => $this->activity_level,
            'body_volume' => $this->body_volume,
            'bd_kg_l' => $this->bd_kg_l,
            'volume1_l' => $this->volume1_l,
            'volume2_l' => $this->volume2_l,
            'volume3_l' => $this->volume3_l,
            'dfm_kg_l' => $this->dfm_kg_l,
            'dffm_kg_l' => $this->dffm_kg_l,
            'tgv_l' => $this->tgv_l,
            'predicted_tgv_l' => $this->predicted_tgv_l,
            'bsa_cm2' => $this->bsa_cm2,
            'comment' => $this->comments
        ];
    }
}
