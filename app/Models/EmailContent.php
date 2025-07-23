<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\HasRevisions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailContent extends Model
{
    use HasFactory, LogsActivity, HasRevisions;

    protected $table = "email_contents";

    protected $fillable = [
        'name',
        'use_for',
        'content',
        'admin_json'
    ];

    protected $casts = [
        'admin_json' => 'array'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty();
    }
}
