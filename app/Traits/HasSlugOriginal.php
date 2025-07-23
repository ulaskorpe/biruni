<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlugOriginal
{

    protected static function bootHasSlugOriginal()
    {
        static::creating(function ($content) {

            $content->slug_org = Str::slug($content->name);

        });

    }


}
