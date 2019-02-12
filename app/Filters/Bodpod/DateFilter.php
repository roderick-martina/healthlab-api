<?php

namespace App\Filters\Bodpod;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;


class DateFilter extends FilterAbstract
{
    public function filter(Builder $builder,$value)
    {
        if ($value === null){
            return $builder;
        }

        $builder->where('test_date', '>=', date($value).' 00:00:00');
    }
}