<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;


class PatientBodpodResultExport implements FromCollection, WithHeadings, WithTitle
{
    private $results;
    private $headings;
    public function __construct($results)
    {
        $this->results = $results;
        $this->headings = DB::getSchemaBuilder()->getColumnListing('bodpods');
    }
    public function headings(): array
    {
        return $this->headings;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->results;
    }
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Bodpod';
    }
}
