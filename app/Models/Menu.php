<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use App\Models\Scopes\LanguageScope;
use App\Traits\HasClearCache;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\HasRevisions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory, LogsActivity, HasRevisions, HasClearCache;

    protected $fillable = [
        'name',
        'language',
        'location',
        'tree'
    ];

    protected $casts = [
        'tree' => 'array'
    ];

    protected static function booted()
    {

        static::addGlobalScope(new LanguageScope);

    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty();
    }
}
