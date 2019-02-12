<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Mbca;
use App\Filters\Patient\PatientFilters;
use App\Models\PatientCustomField;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;


class Patient extends Model
{
    protected $guarded = [''];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function mbca()
    {
        return $this->hasMany(Mbca::class);
        // return $this->hasMany(Mbca::class, 'identifier', 'identifier');
    }
    public function bodpod()
    {
        return $this->hasMany(Bodpod::class);
        // return $this->hasMany(Bodpod::class, 'identifier', 'identifier');
    }
    public function patientCustomField()
    {
        return $this->hasMany(PatientCustomField::class);
    }

    public function getAge()
    {
        if($this->date_of_birth != null) {
            return Carbon::parse($this->date_of_birth)->diffInYears(Carbon::now());;
        } else {
            if($this->mbca) {
                return Carbon::parse($this->mbca->first()->date_of_birth)->diffInYears(Carbon::now());
            } else {
                $this->bodpod->first()->age;
            }
        }
    }

    public function scopeFilter(Builder $builder, Request $request,array $filters = [])
    {
        return (new PatientFilters($request))->add($filters)->filter($builder);
    }
}
