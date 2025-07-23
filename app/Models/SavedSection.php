<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedSection extends Model
{
    use HasFactory;

    protected $table = "saved_sections";

    protected $fillable = ['name','json_data'];

    protected $casts = [
        'json_data' => 'array'
    ];
}
