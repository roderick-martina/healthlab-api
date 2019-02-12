<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;



class PatientExport implements FromCollection, WithHeadings, WithTitle
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function headings(): array
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
        return DB::table('patients')
            ->leftJoin('patient_custom_fields', 'patients.id', '=' ,'patient_custom_fields.patient_id')
            ->leftJoin('custom_fields', 'patient_custom_fields.custom_field_id', '=', 'custom_fields.id')
            ->where('patients.identifier', $this->id)
            ->select(
                'patients.identifier',
                'patients.gender',
                'patients.research_project',
                'patients.date_of_birth',
                'custom_fields.field_name',
                'patient_custom_fields.value',
                'patient_custom_fields.created_at')
            ->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Patient custom fields';
    }
}
