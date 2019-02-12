<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;


interface BodpodRepository
{
    public function findByTestNo($id);
    public function export($id, Request $request);
}