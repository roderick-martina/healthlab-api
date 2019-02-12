<?php

namespace App\Http\Controllers\Devices;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\MbcaImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Mbca;
use App\Models\Patient;
use App\Http\Resources\MbcaResource;
use Illuminate\Support\Facades\Auth as auth;
use App\Filters\Mbca\EthnicFilter;
use App\Exports\MbcaExport;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use App\Jobs\ImportMbca;
use Illuminate\Support\Facades\Storage;
use App\Events\FinishedImportMbcaResults;
use App\Exports\MbcasExport;
use App\Repositories\Contracts\MbcaRepository;
use App\Repositories\Eloquent\Criteria\Eagerload;

class MbcaController extends Controller
{
    private $mbcaRepo;

    public function __construct(MbcaRepository $mbcaRepo)
    {
        $this->mbcaRepo = $mbcaRepo;
        $this->middleware('role:admin', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $mbcas = $this->mbcaRepo->withCriteria([
            new Eagerload(['patient'])
        ])->all($request);
        return MbcaResource::collection($mbcas);
    }

    public function ethnicicties()
    {
        $column = 'ethnic';

        return $this->mbcaRepo->columnList($column);
    }

    public function export($id = null, Request $request)
    {
        return $this->mbcaRepo->export($id, $request);
    }

    public function store(Request $request)
    {
        ini_set('upload_max_filesize', '5M');
        ini_set('post_max_size', '5M');

        $this->validate(request(), [
            'mbca' => 'required|file'
        ]);

        $user = auth('api')->user();
        $fileName = 'mbca';
        $fileId = $this->mbcaRepo->storeFile($request, $fileName);

        try {
            $this->dispatch(new ImportMbca($user, $fileId));
            return response()->json("The import results are being added.", 200);
        } catch (\Exception $e) {
            response()->json(["message" => "Something when't wrong importing the file"], 422);
        }
    }

    public function show($id)
    {
        try {
            return $this->mbcaRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Mbca result for this specific ID does not exist'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $mbca = $this->mbcaRepo->delete($id);
            return new MbcaResource($mbca);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => "Could not find mbca result."
            ], 404);
        }
    }
}
