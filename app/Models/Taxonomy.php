<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    protected $fillable = ['name', 'model_id', 'model_type','language','uuid'];

    protected static function booted()
    {        
        static::creating(function ($c) {
            if(!$c->uuid) {
                $c->uuid = Str::uuid();
            }
        });

    }
    
    public static function isUnique($taxonomy)
    {
        return !static::where('name', $taxonomy)->exists();
    }

    public function content()
    {
        return $this->morphTo();
    }
}
