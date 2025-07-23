<?php

namespace App\Models;

use App\Traits\HasClearCache;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\HasRevisions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, HasRevisions, HasClearCache;

    protected $fillable = [
        'name',
        'layout',
        'is_fullscreen',
        'height',
    ];

    protected $casts = [
        'is_fullscreen' => 'boolean'
    ];

    public function slides(): HasMany
    {
        return $this->hasMany(SliderSlide::class)->ordered();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*','slides'])
        ->logOnlyDirty();
    }
}
