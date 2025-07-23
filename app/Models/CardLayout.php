<?php

namespace App\Models;

use App\Traits\HasClearCache;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardLayout extends Model
{
    use SoftDeletes, HasSlug, LogsActivity, HasClearCache;

    protected $table = "card_layouts";

    protected $fillable = [
        'name',
        'slug',
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
