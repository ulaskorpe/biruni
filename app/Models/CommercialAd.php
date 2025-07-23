<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Scopes\LanguageScope;
use App\Traits\HasClearCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\EloquentSortable\SortableTrait;

class CommercialAd extends Model
{
    use HasFactory,SoftDeletes,SortableTrait, HasClearCache;

    protected $table = 'commercial_ads';

    protected $fillable = [
        'uuid',
        'name',
        'commercial_ad_area_id',
        'language',
        'is_published',
        'main_image_id',
        'link',
        'click_count',
        'start_at',
        'end_at',
        'order_column',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'start_at' => 'datetime',
        'end_at' => 'datetime'
    ];

    protected static function booted()
    {        
        static::creating(function ($content) {
            if(!$content->uuid) {
                $content->uuid = Str::uuid();
            }
        });

        static::addGlobalScope(new LanguageScope);

        static::addGlobalScope('startDate', function (Builder $builder) {
            if (request()->route()->getPrefix() !== 'admin') {
                $builder->where(function($qq) {
                    $qq->whereNull('start_at')
                    ->orWhereDate('start_at', '1970-01-01')
                    ->orWhereDate('start_at', '<=', now());
                });
            }
        });

        static::addGlobalScope('endDate', function (Builder $builder) {
            if (request()->route()->getPrefix() !== 'admin') {
                $builder->where(function ($qq) {
                    $qq->whereNull('end_at')
                    ->orWhereDate('end_at', '1970-01-01')
                    ->orWhereDate('end_at', '>=', now());
                });
            }
        });

        static::addGlobalScope('isPublished', function (Builder $builder) {
            if (request()->route()->getPrefix() !== 'admin') {
                $builder->where('is_published',true);
            }
        });

    }

    public function commercial_ad_area() {
        return $this->belongsTo(CommercialAdArea::class,'commercial_ad_area_id','id');
    }

    public function main_image(){

        return $this->hasOne(Media::class,'id','main_image_id');

    }
}
