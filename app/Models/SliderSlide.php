<?php

namespace App\Models;

use App\Traits\HasClearCache;
use Spatie\Activitylog\LogOptions;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\HasRevisions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SliderSlide extends Model implements Sortable
{
    use HasFactory, SoftDeletes, SortableTrait, LogsActivity, HasRevisions, HasClearCache;

    protected $fillable = [
        'slider_id',
        'title',
        'description',
        'image',
        'mobile_image',
        'video',
        'json_data',
        'order_column ',
    ];

    protected $casts = [
        'image' => 'array',
        'mobile_image' => 'array',
        'video' => 'array',
        'json_data' => 'array',
    ];

    public function slider(){
        return $this->belongsTo(Slider::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty();
    }
    
}
