<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Mbca;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class MbcaExport implements FromCollection, WithHeadings
{
    private $id;
    private $headings;
    public function __construct($id)
    {
        $this->id = $id;
        $this->headings = DB::getSchemaBuilder()->getColumnListing('mbcas');
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
        return Mbca::where('id', $this->id)->get();
    }
}
