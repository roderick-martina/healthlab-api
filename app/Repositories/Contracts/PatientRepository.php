<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;


interface PatientRepository
{
    public function CheckIdentifier($id);
    public function export($id, Request $request);
}