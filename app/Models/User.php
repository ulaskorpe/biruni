<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Support\Str;
use Spatie\Image\Enums\Fit;
use Spatie\Sluggable\HasSlug;
use App\Traits\WithoutAppends;
use App\Traits\HasLibraryMedia;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Sluggable\SlugOptions;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, HasLibraryMedia, InteractsWithMedia, LogsActivity, HasSlug,WithoutAppends;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'password',
        'avatar',
        'avatar_preview_url',
        'sms_promotions',
        'email_promotions',
        'notification_promotions',
        'is_admin',
        'user_type',
        'json_data',
        'is_active',
        'pivot_data',
        'approval_status',
        'approval_date',
        'approved_by',
        'not_approve_reason',
        'summary',
        'slug',
        'uuid',
        'language',
        'old_site_id',
        'old_site_data'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'sms_promotions' => 'boolean',
        'email_promotions' => 'boolean',
        'notification_promotions' => 'boolean',
        'json_data' => 'array',
        'is_active' => 'boolean',
        'is_admin' => 'boolean',
        'pivot_data' => 'array',
        'old_site_data' => 'array',
        'approval_date' => 'datetime'
    ];

    protected static function booted()
    {        
        static::creating(function ($content) {
            if(!$content->uuid) {
                $content->uuid = Str::uuid();
            }
        });

        static::addGlobalScope('isApproved', function (Builder $builder) {
            if (request()->route()->getPrefix() !== 'admin') {
                $builder->where('approval_status',1)->where('is_active',true);
            }
        });

    }
    
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function addresses(){
        return $this->hasMany(UserAddress::class)->with(['country','state','city']);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty();
    }


    public function registerMediaConversions(Media $media = null): void
    {

        $conversions = [
            ['name' => 'preview', 'width' => 200, 'height' => 200],
            ['name' => '100x100', 'width' => 100, 'height' => 100],
            ['name' => '300x300', 'width' => 300, 'height' => 300],
            ['name' => '500x500', 'width' => 500, 'height' => 500],
            ['name' => '992x500', 'width' => 992, 'height' => 500],
            ['name' => '1200x1200', 'width' => 1200, 'height' => 1200],
            ['name' => 'op', 'width' => 1300, 'height' => null],
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
                        ->fit(Fit::Fill, $con['width'], $con['height'])
                        ->background('#FFFFFF')
                        ->format(config('app-ea.app_conversion_media_format'))
                        ->nonQueued();
                }
            }
        }
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('user_'.$this->id);
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
