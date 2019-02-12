<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Bodpod;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class BodpodExport implements FromCollection, WithHeadings
{
    private $id;
    private $headings;
    public function __construct($id)
    {
        $this->id = $id;
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
        return Bodpod::where('id', $this->id)->get();
    }
}
