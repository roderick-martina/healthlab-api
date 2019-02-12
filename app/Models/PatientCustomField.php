<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\patient;

class PatientCustomField extends Model
{
    protected $guarded = [''];

     public function patient()
     {
        return $this->belongsTo(Patient::class);
     }
}
