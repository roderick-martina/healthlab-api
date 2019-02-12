<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Patient;
use Laravel\Passport\HasApiTokens;
use App\Models\Bodpod;
use App\Models\Mbca;
use App\Models\CustomField;
use App\Permissions\HasPermissionsTrait;
use App\Filters\User\UserFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function scopeFilter(Builder $builder, Request $request, array $filters = [])
    {
        return (new UserFilters($request))->add($filters)->filter($builder);
    }
    
    public function getEmailNumberAttribute()
    {
        return explode('@', $this->email)[0];
    }

    public function customfields()
    {
        return $this->hasMany(CustomField::class);
    }
    public function Patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function MbcaResults()
    {
        return $this->hasMany(Mbca::class);
    }
    public function BodpodResults()
    {
        return $this->hasMany(Bodpod::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    public function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('name', $role)) {
                return true;
            }
        }

        return false;
    }

  
}
