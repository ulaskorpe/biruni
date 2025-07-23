<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeoData extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'seo_datas';

    protected $fillable = [
        'title',
        'description',
        'additional',
        'seoable_id',
        'seoable_type'
    ];

    protected $casts = [
        'additional' => 'array'
    ];

    public function seoable()
    {
        return $this->morphTo();
    }
}
