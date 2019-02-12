<?php

namespace App\Filters\Bodpod;

use Illuminate\Database\Eloquent\Builder;
use App\Filters\FilterAbstract;


class GenderFilter extends FilterAbstract
{
    public function mappings()
    {
        return ['Male','Female'];
    }

    public function filter(Builder $builder,$value)
    {
        if ($value === null){
            return $builder;
        }

        $builder->where('gender', $value);
    }
}