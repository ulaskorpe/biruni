<?php

namespace App\Models;

use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;

class PermissionGroup extends Model implements Sortable
{
	use SortableTrait;
	
    protected $table = 'permission_groups';

    protected $fillable = [
		'name',
		'model',
        'order_column'
	];

	public function permissions() {

		return $this->hasMany(SpatiePermission::class);

	}
}
