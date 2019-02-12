<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Http\Request;


class PatientsExport implements FromCollection, WithHeadings
{
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function headings() : array
    {
        return [
            'identifier',
            'gender',
            'research project',
            'date of birth',
            'customfield',
            'value',
            'date created'
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $gender = $this->request->gender;
        $researchProject = $this->request->research_project;
        $customField = $this->request->customfield;
        return DB::table('patients')
            ->leftJoin('patient_custom_fields', 'patients.id', '=', 'patient_custom_fields.patient_id')
            ->leftJoin('custom_fields', 'patient_custom_fields.custom_field_id', '=', 'custom_fields.id')
        // ->where('patient_custom_fields.value', '')
        // ->whereNotNull('custom_fields')
        // ->whereNotNull('patient_custom_fields')
            ->when($customField, function ($query) {
                return $query->whereNotNull('custom_fields')->whereNotNull('patient_custom_fields');
            })
            ->when($gender, function ($query) use ($gender) {
                return $query->where('gender', $gender);
            })
            ->when($researchProject, function ($query) use ($researchProject) {
                return $query->where('research_project', $researchProject);
            })
            ->select(
                'patients.identifier',
                'patients.gender',
                'patients.research_project',
                'patients.date_of_birth',
                'custom_fields.field_name',
                'patient_custom_fields.value',
                'patient_custom_fields.created_at'
            )
            ->get();
    }
}
