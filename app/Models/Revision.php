<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Revision extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['json_data','is_active'];

    protected $casts = [
        'json_data' => 'array',
        'is_active' => 'boolean'
    ];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

}
