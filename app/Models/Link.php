<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use App\Models\Scopes\LanguageScope;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\HasRevisions;

class Link extends Model
{
    use LogsActivity, HasRevisions;

    protected $fillable = ['link', 'linkable_id', 'linkable_type','breadcrumb','language','final_uri'];

    protected $casts = [
        'breadcrumb' => 'array'
    ];

    public static function isUnique($final_uri,$language)
    {   
        return !static::where('final_uri', $final_uri)->where('language',$language)->exists();
    }

    public function linkable()
    {
        return $this->morphTo()->withoutGlobalScope(LanguageScope::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logOnlyDirty();
    }

}
