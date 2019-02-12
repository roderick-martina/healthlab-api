<?php

namespace App\Filters\Patient;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;


class AgeFilter extends FilterAbstract
{
    public function filter(Builder $builder, $value)
    {
        if ($value === null) {
            return $builder;
        }
        $value = $this->decodeValue($value);

        if (count($value) > 1) {
            return $builder->whereBetween('date_of_birth', $value);
        }
       
        return $builder
            ->where('date_of_birth', '!=', null)
            ->whereYear('date_of_birth', Carbon::today()->subYears($value[0])->year);
    }
    protected function decodeValue($value)
    {
        return explode('-', $value);
    }
}