<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommercialAdArea extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'commercial_ad_areas';

    protected $fillable = [
        'uuid',
        'name',
    ];

    protected static function booted()
    {        
        static::creating(function ($content) {
            if(!$content->uuid) {
                $content->uuid = Str::uuid();
            }
        });

    }

    public function commercial_ads() {
        return $this->hasMany(CommercialAd::class,'commercial_ad_area_id','id');
    }

}
