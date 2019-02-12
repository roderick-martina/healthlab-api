<?php

namespace App\Filters\Bodpod;


use App\Filters\FiltersAbstract;
use App\Filters\Bodpod\{GenderFilter,ActivityFilter, AgeFilter, DateFilter, TestNumberFilter};



class BodpodFilters extends FiltersAbstract
{
   protected $filters = [
       'gender' => GenderFilter::class,
       'activity' => ActivityFilter::class,
       'age' => AgeFilter::class,
       'date' => DateFilter::class,
       'testnumber' => TestNumberFilter::class
   ];
}