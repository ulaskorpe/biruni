<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\HasRevisions;
use Illuminate\Database\Eloquent\SoftDeletes;

class DesignTemplate extends Model
{
    use SoftDeletes, LogsActivity, HasRevisions;

    protected $table = 'design_templates';

    protected $fillable = ['name','content','use_columns','use_rows','use_containers'];

    protected $casts = [
        'content' => 'array',
        'use_columns' => 'boolean',
        'use_rows' => 'boolean',
        'use_containers' => 'boolean'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty();
    }
    
}
