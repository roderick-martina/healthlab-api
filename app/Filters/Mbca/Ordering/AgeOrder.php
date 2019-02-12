<?php

namespace App\Filters\Mbca\Ordering;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;


class AgeOrder extends FilterAbstract
{
    public function filter(Builder $builder,$value)
    {
        return $builder->orderBy('age', $this->resolverOrder($value));
    }
}