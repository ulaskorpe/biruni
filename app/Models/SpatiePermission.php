<?php

namespace App\Models;

use Spatie\Permission\Models\Permission;

class SpatiePermission extends Permission
{
    protected $table = 'permissions';

    protected $fillable = [
        'name',
        'view_name',
        'guard_name',
        'permission_group_id',
    ];

    public function permission_group(){
        return $this->belongsTo(PermissionGroup::class);
    }
}
