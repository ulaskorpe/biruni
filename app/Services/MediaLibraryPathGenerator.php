<?php

namespace App\Services;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class MediaLibraryPathGenerator implements PathGenerator
{
    /*
     * Get the path for the given media, relative to the root storage path.
     */
    public function getPath(Media $media): string {
        return $media->created_at->year.'/'.$media->created_at->month.'/'.$media->id.'/';
    }

    /*
     * Get the path for conversions of the given media, relative to the root storage path.
     */
    public function getPathForConversions(Media $media): string {
        return $media->created_at->year.'/'.$media->created_at->month.'/'.$media->id.'/conversions/';
    }

    /*
     * Get the path for responsive images of the given media, relative to the root storage path.
     */
    public function getPathForResponsiveImages(Media $media): string {
        return $media->created_at->year.'/'.$media->created_at->month.'/'.$media->id.'/responsive-images/';
    }
}