<?php

namespace App\Traits;

use App\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasLibraryMedia
{
    public function library_media(): BelongsToMany
    {
        return $this->morphToMany(Media::class, 'model','model_has_medias','model_id');
    }

    public function gallery_images(): BelongsToMany
    {
        return $this->morphToMany(Media::class, 'model','model_has_gallery_images','model_id');
    }

    public function main_image()
    {
        return $this->morphToMany(Media::class, 'model','model_has_main_image','model_id');
    }

    public function header_image(): BelongsToMany
    {
        return $this->morphToMany(Media::class, 'model','model_has_header_image','model_id');
    }

    public function main_video(): BelongsToMany
    {
        return $this->morphToMany(Media::class, 'model','model_has_main_video','model_id');
    }

    public function header_video(): BelongsToMany
    {
        return $this->morphToMany(Media::class, 'model','model_has_header_video','model_id');
    }

}
