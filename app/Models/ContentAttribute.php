<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use App\Traits\HasLibraryMedia;
use App\Traits\HasSlugOriginal;
use Spatie\Sluggable\SlugOptions;
use Spatie\Activitylog\LogOptions;
use App\Models\Scopes\LanguageScope;
use App\Traits\HasClearCache;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\HasRevisions;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentAttribute extends Model implements Sortable
{
    use SoftDeletes, LogsActivity, HasRevisions, HasLibraryMedia, SortableTrait, HasSlug, HasSlugOriginal, HasClearCache;

    protected $fillable = [
        'name',
        'slug',
        'option_type',
        'fe_visible',
        'is_required',
        'order_column',
        'language',
        'uuid',
        'pivot_data',
        'site_view',
        'icon_uri'
    ];

    protected $casts = [
        'fe_visible' => 'boolean',
        'is_required' => 'boolean',
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


    public function content_types(){

        return $this->belongsToMany(
            ContentType::class,
            'content_type_has_attributes',
            'content_attribute_id',
            'content_type_id'
        );

    }


    public function values(){
        return $this->hasMany(ContentAttributeValue::class,'content_attribute_id','id');
    }

    public function connected_content_attributes()
    {
        return $this->hasMany(self::class, 'uuid', 'uuid')->withoutGlobalScope(LanguageScope::class)->with(['values','content_types']);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*','content_types','values'])
        ->logOnlyDirty();
    }

}
