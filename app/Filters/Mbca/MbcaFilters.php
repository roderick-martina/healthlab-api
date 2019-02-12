<?php

namespace App\Filters\Mbca;


use App\Filters\FiltersAbstract;
use App\Filters\Mbca\{GenderFilter,EthnicFilter, AgeFilter, DateFilter, IdentifierFilter, EducationFilter, BmiFilter};
use App\Filters\Mbca\Ordering\AgeOrder;
use App\Filters\Mbca\Ordering\DateOrder;



class MbcaFilters extends FiltersAbstract
{
   protected $filters = [
       'gender' => GenderFilter::class,
       'research_project' => EducationFilter::class,
       'ethnic' => EthnicFilter::class,
       'age' => AgeFilter::class,
       'date' => DateFilter::class,
       'age_order' => AgeOrder::class,
       'date_order' => DateOrder::class,
       'identifier' => IdentifierFilter::class,
       'bmi' => BmiFilter::class
   ];
}