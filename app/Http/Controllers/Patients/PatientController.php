<?php

namespace App\Http\Controllers\Patients;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Http\Resources\PatientResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Exports\PatientExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PatientsExport;
use App\Exports\PatientResultSheet;
use App\Exports\PatientsResultSheet;
use App\Repositories\Eloquent\Criteria\Eagerload;
use App\Repositories\Contracts\PatientRepository;


class PatientController extends Controller
{
    private $patientRepo;

    public function __construct(PatientRepository $patientRepo)
    {
        $this->patientRepo = $patientRepo;
        $this->middleware('role:admin', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $patients = $this->patientRepo->withCriteria([
            new Eagerload(['mbca.patient', 'bodpod.patient', 'patientCustomField.patient'])
        ])->all($request);
        return PatientResource::collection($patients);
    }

    public function researchProject()
    {
        $column = 'research_project';

        return $this->patientRepo->columnList($column);
    }

    public function export($id = null, Request $request)
    {
        return $this->patientRepo->export($id, $request);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'identifier' => 'required|string|unique:patients',
            'gender' => 'required',
            'date_of_birth' => 'required'
        ]);

        $patientValidIdentifier = $this->patientRepo->CheckIdentifier($request->identifier);

        $patient = $this->patientRepo->create([
            'identifier' => $request->identifier,
            'research_project' => $request->research_project,
            'valid_identifier' => $patientValidIdentifier,
            'gender' =>  $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'manuel_created' => true
        ]);

        return new PatientResource($patient);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $patient = $this->patientRepo->findWhereFirst('identifier', $id);
            return new PatientResource($patient);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => "Could not find patient with the ID: {$id}"
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'identifier' => 'required|string|unique:patients'
        ]);

        try {
            $patient = $this->patientRepo->update($id, [
                'identifier' => $request->identifier
            ]);
            return new PatientResource($patient);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => "Could not find patient with the ID: {$id}"
            ], 404);
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
            $patient = $this->patientRepo->delete($id);
            return new PatientResource($patient);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => "Could not find patient with the ID: {$id}"
            ], 404);
        }
    }
}
