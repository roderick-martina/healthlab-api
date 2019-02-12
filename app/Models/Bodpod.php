<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Filters\Bodpod\BodpodFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Patient;

class Bodpod extends Model
{
    protected $guarded = [];

    public function scopeFilter(Builder $builder, Request $request,array $filters = [])
    {
        return (new BodpodFilters($request))->add($filters)->filter($builder);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
