<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\CustomFieldRepository;
use Illuminate\Http\Request;
use App\Repositories\RepositoryAbstract;
use App\Models\CustomField;


class EloquentCustomFieldRepository  extends RepositoryAbstract implements CustomFieldRepository
{
    public function model()
    {
        return CustomField::class;
    }

    public function all(Request $request)
    {
        if ($request->paginate) {
            return CustomField::paginate(7);
        }
        
        return CustomField::all();
    }
}