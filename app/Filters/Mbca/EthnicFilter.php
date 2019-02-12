<?php

namespace App\Filters\Mbca;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;


class EthnicFilter extends FilterAbstract
{
    public function filter(Builder $builder,$value)
    {
        if ($value === null){
            return $builder;
        }
        
        $builder->where('ethnic', $value);
    }
}