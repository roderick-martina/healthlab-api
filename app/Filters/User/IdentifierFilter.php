<?php

namespace App\Filters\User;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;


class IdentifierFilter extends FilterAbstract
{
    public function filter(Builder $builder,$value)
    {
        if ($value === null){
            return $builder;
        }

        $builder->where('email','like' , "%{$value}%");
    }
}