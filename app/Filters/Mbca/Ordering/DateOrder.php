<?php

namespace App\Filters\Mbca\Ordering;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;


class DateOrder extends FilterAbstract
{
    public function filter(Builder $builder,$value)
    {
        return $builder->orderBy('created', $this->resolverOrder($value));
    }
}