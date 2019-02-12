<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\MbcaRepository;
use App\Models\Mbca;
use App\Http\Resources\MbcaResource;
use Illuminate\Http\Request;
use App\Repositories\RepositoryAbstract;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MbcasExport;
use App\Exports\MbcaExport;


class EloquentMbcaRepository  extends RepositoryAbstract implements MbcaRepository
{
    public function model()
    {
        return Mbca::class;
    }

    public function export($id, Request $request)
    {
        if ($id) {
            return Excel::download(new MbcaExport($id), 'mbca-result.xlsx');
        } else {
            return Excel::download(new MbcasExport($request), 'mbca-results.xlsx');
        }
    }
}