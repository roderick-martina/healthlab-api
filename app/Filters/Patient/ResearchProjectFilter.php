<?php

namespace App\Filters\Patient;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;


class ResearchProjectFilter extends FilterAbstract
{
    public function filter(Builder $builder,$value)
    {
        if ($value === null){
            return $builder;
        }
        
        $builder->where('research_project', $value);
    }
}