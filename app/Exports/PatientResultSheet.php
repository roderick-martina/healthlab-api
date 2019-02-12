<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\Patient;

class PatientResultSheet implements WithMultipleSheets
{
    use Exportable;
    private $id;
    private $patient;

    public function __construct($id)
    {
        $this->id = $id;
        $this->patient = Patient::where('identifier', $id)->first();
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        array_push($sheets,new PatientExport($this->id)); 
        array_push($sheets, new PatientMbcaResultExport($this->patient->mbca));
        array_push($sheets, new PatientBodpodResultExport($this->patient->bodpod));

        return $sheets;
    }
}