<?php

namespace App\Filters\Patient;


use App\Filters\FiltersAbstract;
use App\Filters\Patient\{GenderFilter, AgeFilter, ResearchProjectFilter, IdentifierFilter};

class PatientFilters extends FiltersAbstract
{
   protected $filters = [
       'gender' => GenderFilter::class,
       'age' => AgeFilter::class,
       'identifier' => IdentifierFilter::class,
       'research_project' => ResearchProjectFilter::class
   ];
}