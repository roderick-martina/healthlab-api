<?php

namespace App\Http\Controllers\CustomFields;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CustomField;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\PatientCustomField;
use App\Models\Patient;
use App\Http\Resources\PatientCustomFieldResource;
use App\Repositories\Contracts\PatientCustomFieldRepository;
use App\Repositories\Contracts\CustomFieldRepository;
use App\Repositories\Contracts\PatientRepository;

class PatientCustomFieldController extends Controller
{
    private $patientCustRepo;
    private $patientRepo;
    private $custRepo;

    public function __construct(PatientCustomFieldRepository $patientCustRepo, CustomFieldRepository $custRepo, PatientRepository $patientRepo)
    {
        $this->patientCustRepo = $patientCustRepo;
        $this->custRepo = $custRepo;
        $this->patientRepo = $patientRepo;
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'patient_id' => 'required',
            'custom_field_id' => 'required',
            'value' => 'required'
        ]);

        try {
            $customField = $this->custRepo->find($request->custom_field_id);
            $patient = $this->patientRepo->find($request->patient_id);

            $patientCustomField = $this->patientCustRepo->create([
                'patient_id' => $patient->id,
                'custom_field_id' => $customField->id,
                'value' => $request->value,
            ]);

            return new PatientCustomFieldResource($patientCustomField);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => "Something when't wrong"
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $patientCustomField = $this->patientCustRepo->delete($id);
            return new PatientCustomFieldResource($patientCustomField);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => "Something when't wrong deleting the patient customfield result"
            ], 404);
        }
    }
}
