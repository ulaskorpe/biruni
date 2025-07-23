<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use App\Models\Scopes\LanguageScope;
use App\Traits\HasClearCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\HasRevisions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory, LogsActivity, HasRevisions,SoftDeletes,HasClearCache;

    protected $table = "announcements";

    protected $fillable = [
        'name',
        'description',
        'users_only',
        'start_date',
        'end_date',
        'uuid',
        'language'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'users_only' => 'boolean',
    ];

    protected static function booted()
    {

        static::creating(function ($c) {
            if(!$c->uuid) {
                $c->uuid = Str::uuid();
            }
        });

        static::addGlobalScope(new LanguageScope);
        
        static::addGlobalScope('publishDate', function (Builder $builder) {
            if (request()->route()->getPrefix() !== 'admin') {
                $builder->where(function ($qq) {
                    $qq->whereNull('start_date')
                    ->orWhereDate('start_date', '1970-01-01')
                    ->orWhereDate('start_date', '<=', now());
                });
            }
        });

        static::addGlobalScope('endDate', function (Builder $builder) {
            if (request()->route()->getPrefix() !== 'admin') {
                $builder->where(function ($qq) {
                    $qq->whereNull('end_date')
                    ->orWhereDate('end_date', '1970-01-01')
                    ->orWhereDate('end_date', '>=', now());
                });
            }
        });
    }

    public function connected_announcements()
    {
        return $this->hasMany(self::class, 'uuid', 'uuid')->withoutGlobalScope(LanguageScope::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty();
    }
}
