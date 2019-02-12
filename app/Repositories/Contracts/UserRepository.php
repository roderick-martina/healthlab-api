<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;
use App\User;

interface UserRepository
{
    public function assignStudentRole(User $user);
    public function login(Request $request);
    public function updatePassword(Request $request);
    public function refreshToken(User $user);
}