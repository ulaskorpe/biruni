<?php

namespace App\Models;

use App\Traits\HasClearCache;
use Spatie\Sluggable\HasSlug;
use App\Traits\HasSlugOriginal;
use Spatie\Sluggable\SlugOptions;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\HasRevisions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sidebar extends Model
{
    use SoftDeletes, HasSlug, HasSlugOriginal, LogsActivity, HasRevisions, HasClearCache;

    protected $table = "sidebars";

    protected $fillable = [
        'name',
        'slug',
        'is_global',
        'json_data',
        'content'
    ];

    protected $casts = [
        'is_global' => 'boolean',
        'json_data' => 'array',
        'content' => 'array',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty();
    }
    
}
