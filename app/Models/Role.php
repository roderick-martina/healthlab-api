<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;

class Role extends Model
{
    protected $fillable = ['name'];
    public function permissons()
    {
        return $this->hasMany(Permission::class, 'roles_permissions');
    }
}
