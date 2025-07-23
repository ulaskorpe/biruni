<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use App\Traits\HasSlugOriginal;
use Spatie\Sluggable\SlugOptions;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeaderLayout extends Model
{
    use SoftDeletes, HasSlug, HasSlugOriginal, LogsActivity;

    protected $table = "header_layouts";

    protected $fillable = [
        'name',
        'slug',
        'slug_org',
        'json_data',
        'content'
    ];

    protected $casts = [
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
