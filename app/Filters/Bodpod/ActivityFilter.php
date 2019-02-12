<?php

namespace App\Filters\Bodpod;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;


class ActivityFilter extends FilterAbstract
{
    public function filter(Builder $builder,$value)
    {
        if ($value === null){
            return $builder;
        }
        $builder->where('activity_level', $value);
    }
}