<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\PatientCustomFieldRepository;
use Illuminate\Http\Request;
use App\Repositories\RepositoryAbstract;
use App\Models\PatientCustomField;

class EloquentPatientCustomFieldRepository extends RepositoryAbstract implements PatientCustomFieldRepository
{
    public function model()
    {
        return PatientCustomField::class;
    }

}