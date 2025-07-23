<?php

namespace App\Models;

use App\Traits\HasLink;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use App\Traits\HasSlugOriginal;
use Spatie\Sluggable\SlugOptions;
use Spatie\Activitylog\LogOptions;
use App\Models\Scopes\LanguageScope;
use App\Traits\HasClearCache;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\HasRevisions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes, SortableTrait, HasSlug, HasLink, HasSlugOriginal, LogsActivity, HasRevisions, HasClearCache;

    protected $fillable = [
        'name',
        'slug','slug_org',
        'order_column',
        'language',
        'uuid'
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
    
    public function connected_tags()
    {
        return $this->hasMany(self::class, 'uuid', 'uuid')->withoutGlobalScope(LanguageScope::class)->select('id','uuid','name','language');
    }
    
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function contents()
    {
        return $this->morphedByMany(Content::class, 'model','model_has_tags')->select('id','name','language','uuid','additional','summary')->with(['uri:linkable_id,final_uri','seo_data']);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty();
    }
}
