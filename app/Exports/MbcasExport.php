<?php

namespace App\Exports;

use App\Models\Mbca;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Http\Request;

class MbcasExport implements FromCollection, WithHeadings, WithTitle
{
    private $request;
    private $headings;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->headings = DB::getSchemaBuilder()->getColumnListing('mbcas');
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function collection()
    {
        return Mbca::filter($this->request)->get();
        // return Mbca::all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Mbca';
    }
}