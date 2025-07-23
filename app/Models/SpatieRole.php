<?php

namespace App\Models;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SpatieRole extends Role
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = ['view_name','name','description'];

    protected static function booted()
    {
        static::creating(function ($role) {
            $role->guard_name = 'web';
        });

        /*
		static::addGlobalScope('superadmin', function (Builder $builder) {
            $builder->where('name', '!=', 'super-admin');
        });
        */

    }

}
