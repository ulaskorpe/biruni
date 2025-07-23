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

class Layout extends Model
{
    use SoftDeletes, HasSlug, HasSlugOriginal, LogsActivity, HasRevisions, HasClearCache;

    protected $table = "layouts";

    protected $fillable = [
        'name',
        'slug',
        'full_width',
        'left_sidebar',
        'right_sidebar',
        'json_data',
        'left_sidebar_id',
        'right_sidebar_id',
        'content'
    ];

    protected $casts = [
        'full_width' => 'boolean',
        'left_sidebar' => 'boolean',
        'right_sidebar' => 'boolean',
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

    public function left_sidebar_details(){
        return $this->belongsTo(Sidebar::class,'left_sidebar_id','id');
    }

    public function right_sidebar_details(){
        return $this->belongsTo(Sidebar::class,'right_sidebar_id','id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty();
    }
    
    
}
