<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;


interface RepositoryInterface
{
    public function all(Request $request);
    public function find($id);
    public function findWhereFirst($column, $value);
    public function delete($id);
    public function storeFile(Request $request, string $filename);
    public function columnList(string $string);
    public function update($id, array $properties);
}