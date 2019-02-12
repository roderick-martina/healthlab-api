<?php

namespace App\Filters\Bodpod;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;


class AgeFilter extends FilterAbstract
{
    public function filter(Builder $builder,$value)
    {
        if ($value === null){
            return $builder;
        }
        $value = $this->decodeValue($value);

        if(count($value) > 1){
            return $builder->whereBetween('age', $value);
        }
        return $builder->where('age', '>=', $value);
       
    }
    protected function decodeValue($value)
    {
        return explode('-', $value);
    }
}