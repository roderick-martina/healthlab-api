<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientsResultSheet implements WithMultipleSheets
{
    use Exportable;
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        array_push($sheets,new PatientsExport($this->request)); 
        // array_push($sheets, new MbcasExport());
        // array_push($sheets, new BodpodsExport());

        return $sheets;
    }
}