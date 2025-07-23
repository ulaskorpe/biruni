<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use App\Traits\HasLibraryMedia;
use App\Traits\HasSlugOriginal;
use Spatie\Sluggable\SlugOptions;
use Spatie\Activitylog\LogOptions;
use App\Models\Scopes\LanguageScope;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\HasRevisions;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentAttributeValue extends Model implements Sortable
{
    use SoftDeletes, LogsActivity, HasRevisions, HasLibraryMedia, SortableTrait, HasSlug, HasSlugOriginal;

    protected $fillable = [
        'content_attribute_id',
        'name',
        'slug',
        'language',
        'uuid',
        'pivot_data',
        'color_value',
        'image_uri'
    ];

    protected $casts = [
        'pivot_data' => 'array',
    ];
    
    protected static function booted()
    {        
        static::creating(function ($c) {
            if(!$c->uuid) {
                $c->uuid = Str::uuid();
            }
        });

        static::addGlobalScope(new LanguageScope);

    }
    
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
