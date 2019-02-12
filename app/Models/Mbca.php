<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\Mbca\MbcaFilters;
use Illuminate\Http\Request;
use App\User;


class Mbca extends Model
{
    protected $guarded = [''];
    // protected $fillable = ['date_of_birth','patient_id','gender','doctor','created'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $builder, Request $request, array $filters = [])
    {
        return (new MbcaFilters($request))->add($filters)->filter($builder);
    }

    public function resolveComment(String $comment)
    {
        if (str_contains($comment, ';')) {
            return explode(';', $comment);
        }

        return $comment;
    }

    public function getAge()
    {
        return Carbon::parse($this->date_of_birth)->diffInYears(Carbon::now());;

    }
}
