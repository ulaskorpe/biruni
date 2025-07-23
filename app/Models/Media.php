<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class Media extends BaseMedia
{

    use LogsActivity;

    protected $appends = ['preview_url','original_url','conversion_urls'];

    protected function getConversionUrlsAttribute()
    {
        $urls = [];

        foreach ($this->generated_conversions as $key => $conversion) {
            
            if($key != 'tusacan'){
                $urls[$key.'_url'] = $this->getUrl($key);
            }

        }

        return $urls;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty();
    }

}
