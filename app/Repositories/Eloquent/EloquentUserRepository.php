<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\UserRepository;
use Illuminate\Http\Request;
use App\Repositories\RepositoryAbstract;
use App\User;
use App\Models\Role;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class EloquentUserRepository extends RepositoryAbstract implements UserRepository
{
    public function model()
    {
        return User::class;
    }

    public function assignStudentRole($user)
    {
        if (Role::where('name', 'student')->get()->count() == 0) {
            $role = Role::create([
                'name' => 'student'
            ]);
            $user->roles()->attach($role->id);
        } else {
            $role = Role::where('name', 'student')->firstOrFail();
            $user->roles()->attach($role->id);
        }
    }

    public function login(Request $request)
    {
        $http = new Client();

        $response = $http->post(env("PASSPORT_TOKEN_URL"), [
            'form_params' => [
                'grant_type' => env("PASSPORT_GRANT_TYPE"),
                'client_id' => env("PASSPORT_CLIENT_ID"),
                'client_secret' => env("PASSPORT_CLIENT_SECRET"),
                'username' => $request->email,
                'password' => $request->password
            ]
        ]);

        return $response;
    }
    public function updatePassword(Request $request)
    {
        $user = auth('api')->user();

        $this->update($user->id, [
            'password' => Hash::make($request->password)
        ]);

        return $user;
    }

    public function refreshToken(User $user)
    {
        $user->token()->revoke();
        $token = $user->createToken('newToken')->accessToken;
        return $token;
    }

    public function logout()
    {
        $user = auth('api')->user();
        $user->tokens->each(function ($token, $key) {
            $token->delete();
        });
    }

    public function deleteUser($userToDeleteId)
    {
        $currentUser = auth('api')->user();

        if ($currentUser->id != $userToDeleteId) {
            $user = $this->find($userToDeleteId);
            $user->delete();
            return $user;
        }

        throw new ModelNotFoundException();
    }
}