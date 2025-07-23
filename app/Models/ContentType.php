<?php

namespace App\Models;

use App\Traits\HasTaxonomy;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use App\Traits\HasSlugOriginal;
use Spatie\Sluggable\SlugOptions;
use Spatie\Activitylog\LogOptions;
use App\Models\Scopes\LanguageScope;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\HasRevisions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContentType extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, HasRevisions,HasSlug, HasSlugOriginal,HasTaxonomy;

    protected $table = "content_types";

    protected $fillable = [
        'name',
        'slug',
        'has_category',
        'has_url',
        'is_published',
        'additional',
        'is_deletable',
        'layout_id',
        'use_taxonomy_link',
        'content_category_list_template_id',
        'content_category_default_list_type',
        'card_layout_id',
        'language',
        'uuid',
        'content_mode',
        'depending_content_type_id',
        'offcanvas'
    ];

    protected $casts = [
        'has_category' => 'boolean',
        'has_url' => 'boolean',
        'is_published' => 'boolean',
        'is_deletable' => 'boolean',
        'additional' => 'array',
        'use_taxonomy_link' => 'boolean',
        'offcanvas' => 'boolean',
    ];

    protected static function booted()
    {        
        static::creating(function ($c) {
            if(!$c->uuid) {
                $c->uuid = Str::uuid();
            }
            if(!$c->language) {
                $c->language = config('languages.default');
            }
        });

        static::addGlobalScope(new LanguageScope);

    }
    
    public function connected_content_types()
    {
        return $this->hasMany(self::class, 'uuid', 'uuid')->withoutGlobalScope(LanguageScope::class)->with('taxonomy');
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function contents(){
        return $this->hasMany(Content::class)->withoutGlobalScope(LanguageScope::class);
    }

    public function layout() {
        return $this->belongsTo(Layout::class,'layout_id');
    }

    public function categories() {
        return $this->hasMany(ContentCategory::class)->withoutGlobalScope(LanguageScope::class);
    }

    public function content_attributes()
    {
        return $this->belongsToMany(
            ContentAttribute::class,
            'content_type_has_attributes',
            'content_type_id',
            'content_attribute_id'
        )->with('values');

    }

    public function category_list_template(){

        return $this->belongsTo(ContentCategoryListTemplate::class,'content_category_list_template_id');

    }

    public function card_layout(){

        return $this->belongsTo(CardLayout::class,'card_layout_id');

    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty();
    }


}
