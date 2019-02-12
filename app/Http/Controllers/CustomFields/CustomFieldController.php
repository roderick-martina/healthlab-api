<?php

namespace App\Http\Controllers\CustomFields;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CustomField;
use App\Models\Patient;
use App\Http\Resources\CustomFieldResource;
use App\Repositories\Contracts\CustomFieldRepository;

class CustomFieldController extends Controller
{
    private $custRepo;

    public function __construct(CustomFieldRepository $custRepo)
    {
        $this->custRepo = $custRepo; 
        $this->middleware('role:admin', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $customfields = $this->custRepo->all($request);
        return CustomFieldResource::collection($customfields);
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'field_name' => 'required|unique:custom_fields',
        ]);

        $customfield = $this->custRepo->create([
            'field_name' => $request->field_name
        ]);

        return new CustomFieldResource($customfield);

    }

    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'field_name' => 'required'
        ]);

        $customfield = $this->custRepo->update($id,[
            'field_name' => $request->field_name
        ]);

        return new CustomFieldResource($customfield);
    }

    public function destroy($id)
    {

        try {
            $customfield = $this->custRepo->delete($id);
            return new CustomFieldResource($customfield);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => "Could not find customfield."
            ], 404);
        }
    }
}
