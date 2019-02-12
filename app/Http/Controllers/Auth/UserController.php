<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Calculation\Exception;
use GuzzleHttp\Exception\ClientException;
use App\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Eloquent\Criteria\Eagerload;


class Usercontroller extends Controller
{
    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
        $this->middleware('role:admin', ['only' => ['destroy', 'getUsers']]);
    }

    public function register(Request $request)
    {
        $this->validate(request(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6']
        ]);

        $user = $this->userRepo->create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        $this->userRepo->assignStudentRole($user);

        return new UserResource($user);
    }

    public function login(Request $request)
    {
        $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            $response = $this->userRepo->login($request);
            return json_decode((string)$response->getBody(), true);
        } catch (ClientException $e) {
            return response()->json([
                'errors' => 'The user credentials where incorrect'
            ], 422);
        }
    }

    public function update(Request $request)
    {
        $this->validate(request(), [
            'password' => ['required', 'string', 'min:6']
        ]);

        $user = $this->userRepo->updatePassword($request);

        $token = $this->userRepo->refreshToken($user);

        return (new UserResource($user))->additional([
            'token' => $token
        ]);
    }

    public function logout()
    {
        $this->userRepo->logout();

        return response()->json('Logged out succesfully', 200);
    }

    public function getUsers(Request $request)
    {
        $users = $this->userRepo->withCriteria([
            new Eagerload(['roles'])
        ])->all($request);
        return UserResource::collection($users);
    }

    public function destroy($id)
    {
        try {
            $user = $this->userRepo->deleteUser($id);
            return new UserResource($user);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => "Could not find user."
            ], 404);
        }
    }
}
