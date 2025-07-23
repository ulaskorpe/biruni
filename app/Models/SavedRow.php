<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedRow extends Model
{
    use HasFactory;

    protected $table = "saved_rows";

    protected $fillable = ['name','json_data'];

    protected $casts = [
        'json_data' => 'array'
    ];
}
