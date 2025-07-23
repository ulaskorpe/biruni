<?php

namespace App\Traits;

use App\Models\Revision;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Spatie\ResponseCache\Facades\ResponseCache;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasClearCache
{
    protected static function bootHasClearCache()
    {
        
        static::created(function () {

            Cache::flush();
            ResponseCache::clear();

        });

        static::updated(function () {
            
            Cache::flush();
            ResponseCache::clear();

        });

        static::deleted(function () {
            
            Cache::flush();
            ResponseCache::clear();

        });

    }


}
