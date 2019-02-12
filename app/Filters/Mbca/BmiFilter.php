<?php

namespace App\Filters\Mbca;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;


class BmiFilter extends FilterAbstract
{
    public function filter(Builder $builder,$value)
    {
        if ($value === null){
            return $builder;
        }
        $value = $this->decodeValue($value);

        if(count($value) > 1){
            return $builder->whereBetween('bmi_value', $value);
        }
        return $builder->where('bmi_value','>=', $value);
       
    }
    protected function decodeValue($value)
    {
        return explode('-', $value);
    }
}