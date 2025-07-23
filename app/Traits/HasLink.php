<?php

namespace App\Traits;

use App\Models\Link;
use App\Models\SeoData;

trait HasLink
{

    protected static function bootHasLink()
    {
        static::created(function ($content) {

            $link = new Link();
            generateUri($content,$link,false,request()->category_for_uri ?? null);

        });

        static::forceDeleted(function ($content) {
            if ($content->uri) {
                $content->uri()->delete();
            }
            if ($content->seo_data) {
                $content->seo_data()->delete();
            }
        });
    }

    public function uri()
    {
        return $this->morphOne(Link::class, 'linkable');
    }

    public function seo_data()
    {
        return $this->morphOne(SeoData::class, 'seoable');
    }

}
