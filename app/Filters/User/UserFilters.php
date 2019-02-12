<?php

namespace App\Filters\User;


use App\Filters\FiltersAbstract;
use App\Filters\User\{IdentifierFilter};

class UserFilters extends FiltersAbstract
{
   protected $filters = [
       'identifier' => IdentifierFilter::class,
   ];
}