<?php

namespace App\Repositories\Eloquent;

use Illuminate\Http\Request;
use App\Repositories\RepositoryAbstract;
use App\Repositories\Contracts\PatientRepository;
use App\Models\Patient;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PatientResultSheet;
use App\Exports\PatientsResultSheet;


class EloquentPatientRepository  extends RepositoryAbstract implements PatientRepository
{
    public function model()
    {
        return Patient::class;
    }

    public function export($id, Request $request)
    {
        if($id) {
            return Excel::download(new PatientResultSheet($id), "patient.xlsx");
        } else {
            return Excel::download(new PatientsResultSheet($request), "patients.xlsx");
        }
    }

    public function CheckIdentifier($id)
    {
        if (preg_match("/^20[0-9]{2}[0-9]{4}$/", $id) != 0) {
            return true;
        } else {
            return false;
        }
    }
}