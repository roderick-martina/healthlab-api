<?php

namespace App\Filters\Bodpod;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Patient;


class TestNumberFilter extends FilterAbstract
{
    public function filter(Builder $builder,$value)
    {
        if ($value === null){
            return $builder;
        }


        $builder->where('test_no', $value);
    }
}