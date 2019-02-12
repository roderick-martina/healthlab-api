<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface MbcaRepository
{
    public function export($id, Request $request);
}