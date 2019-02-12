<?php

namespace App\Filters\Mbca;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Patient;


class IdentifierFilter extends FilterAbstract
{
    public function filter(Builder $builder,$value)
    {
        if ($value === null){
            return $builder;
        }

        // if($patient = Patient::where('identifier', $value)->first()) {
        //     return $patient->mbca()->where('identifier', $value);
        // } else{
        //     return $builder;
        // }
        // dd($builder->first());
        $builder->where('identifier', $value);
    }
}