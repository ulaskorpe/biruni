<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use App\Traits\HasSlugOriginal;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentCategoryListTemplate extends Model
{
    use SoftDeletes, HasSlug, HasSlugOriginal;

    protected $table = 'content_category_list_templates';

    protected $fillable = [
        'name',
        'slug',
        'layout',
        'additional',
    ];

    protected $casts = [
        'additional' => 'array',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }
}
