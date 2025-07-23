<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class LanguageScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {

        $language = request()->has('language') && in_array(request()->language,config('languages.active')) 
        ? request()->language 
        : ( session()->has('session_language') ? session()->get('session_language') : config('languages.default'));

        $builder->where('language',$language);
    }
}
