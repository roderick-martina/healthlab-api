<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\BodpodRepository;
use App\Models\Bodpod;
use App\Http\Resources\BodpodResource;
use Illuminate\Http\Request;
use App\Repositories\RepositoryAbstract;
use App\Exports\BodpodExport;
use App\Exports\BodpodsExport;
use Maatwebsite\Excel\Facades\Excel;


class EloquentBodpodRepository extends RepositoryAbstract implements BodpodRepository
{
    public function model()
    {
        return Bodpod::class;
    }

    public function findByTestNo($id)
    {
        return Bodpod::where('test_no',$id)->firstOrFail();
    }

    public function export($id, Request $request)
    {
        // dd($request->all());
        if ($id) {
            return Excel::download(new BodpodExport($id), 'bodpod-results.xlsx');
        } else {
            return Excel::download(new BodpodsExport($request), 'bodpods-results.xlsx');
        }
    }
}