<?php

namespace App\Http\Controllers\Devices;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\BodpodImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\BodpodResource;
use App\Models\Bodpod;
use App\Exports\BodpodExport;
use Illuminate\Support\Collection;
use PHPUnit\Runner\Exception;
use App\Jobs\ImportBodpod;
use Illuminate\Support\Facades\Storage;
use App\Exports\BodpodsExport;
use App\Repositories\Contracts\BodpodRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BodpodController extends Controller
{
    private $bodpodRepo;

    public function __construct(BodpodRepository $bodpodRepo)
    {
        $this->bodpodRepo = $bodpodRepo;
        $this->middleware('role:admin', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return BodpodResource::collection($this->bodpodRepo->all($request));
    }
    public function activities()
    {
        $column = 'activity_level';
        return $this->bodpodRepo->columnList($column);
    }
    public function store(Request $request)
    {
        ini_set('upload_max_filesize', '5M');
        ini_set('post_max_size', '5M');

        $this->validate(request(), [
            'bodpod' => 'required|file'
        ]);

        $user = auth('api')->user();
        $fileName = 'bodpod';
        $fileId = $this->bodpodRepo->storeFile($request, $fileName);

        try {
            $this->dispatch(new ImportBodpod($user, $fileId));
            return response()->json("The import results are being added.", 200);
        } catch (\Exception $e) {
            response()->json(["message" => "Something when't wrong importing the file"], 422);
        }
    }

    public function export($id = null, Request $request)
    {
        return $this->bodpodRepo->export($id,$request);
    }

    public function show($id)
    {
        try {
            return $this->bodpodRepo->findByTestNo($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Bodpod result for this specific ID does not exist'
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
            $bodpod = $this->bodpodRepo->delete($id);
            return new BodpodResource($bodpod);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => "Could not find bodpod result."
            ], 404);
        }
    }
}
