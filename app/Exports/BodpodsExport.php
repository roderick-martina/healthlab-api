<?php

namespace App\Exports;

use App\Models\Bodpod;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\User;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Http\Request;

class BodpodsExport implements FromCollection, WithHeadings, WithTitle
{
    private $request;
    private $headings;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->headings = DB::getSchemaBuilder()->getColumnListing('bodpods');
    }

    public function headings(): array
    {
        return $this->headings;
    }
    public function collection()
    {
        return Bodpod::filter($this->request)->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'bodpod';
    }
}