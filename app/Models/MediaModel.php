<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MediaModel extends Authenticatable implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'media_models';

    public function registerMediaConversions(Media $media = null): void
    {

        $conversions = [
            ['name' => 'preview', 'width' => 200, 'height' => 200],
            ['name' => '100x100', 'width' => 100, 'height' => 100],
            ['name' => '300x300', 'width' => 300, 'height' => 300],
            ['name' => '500x500', 'width' => 500, 'height' => 500],
            ['name' => '992x500', 'width' => 992, 'height' => 500],
            ['name' => '1200x1200', 'width' => 1200, 'height' => 1200],
            ['name' => 'op', 'width' => 1920, 'height' => null],
            ['name' => 'th', 'width' => 992, 'height' => null],
        ];

        if (config('app-ea.app_media_resize_rule') == 'skip') {

            foreach ($conversions as $con) {
                if ($this->isConversionNecessary($media, $con['width'], $con['height'])) {
                    $this->addMediaConversion($con['name'])
                        ->fit(Fit::Crop, $con['width'], $con['height'])
                        ->format(config('app-ea.app_conversion_media_format'))
                        ->nonQueued();
                }
            }
        }

        if (config('app-ea.app_media_resize_rule') == 'padding') {

            foreach ($conversions as $con) {

                //en boy buyukse cropla. degilse bosluk ekleyerek olustur.
                if ($this->isConversionNecessary($media, $con['width'], $con['height'])) {
                    $this->addMediaConversion($con['name'])
                        ->fit(Fit::Crop, $con['width'], $con['height'])
                        ->format(config('app-ea.app_conversion_media_format'))
                        ->nonQueued();
                } else {

                    $this->addMediaConversion($con['name'])
                        ->fit(Fit::Fill, $con['width'], $con['height']) // FIT_CONTAIN kullanılıyor
                        ->format(config('app-ea.app_conversion_media_format'))
                        ->nonQueued();
                }
            }
        }
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('library');
    }

    protected function isConversionNecessary(Media $media, ?int $targetWidth, ?int $targetHeight): bool
    {
        $imagePath = $media->getPath();
        $extension = strtolower($media->extension);

        if ($extension === 'svg') {
            // SVG boyutlarını analiz et
            $svgContent = file_get_contents($imagePath);
            if (
                preg_match('/<svg[^>]+width=["\']?(\d+)(px)?["\']?[^>]*>/i', $svgContent, $widthMatch) &&
                preg_match('/<svg[^>]+height=["\']?(\d+)(px)?["\']?[^>]*>/i', $svgContent, $heightMatch)
            ) {
                $width = (int)$widthMatch[1];
                $height = (int)$heightMatch[1];
            } else {
                // Eğer width ve height bilgisi yoksa varsayılan olarak gerekli dönüşümü yap
                return true;
            }
        } else {
            // Raster görüntüleri analiz et
            [$width, $height] = getimagesize($imagePath);
        }

        if ($targetWidth && $width < $targetWidth) return false;
        if ($targetHeight && $height < $targetHeight) return false;

        return true;
    }
}
