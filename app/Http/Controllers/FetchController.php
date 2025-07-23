<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use App\Models\ContentCategory;
use App\Models\Scopes\LanguageScope;

class FetchController extends Controller
{
    
    public function contentCategories(Request $request) {

        if( $request->wantsJson() ){

            return ContentCategory::select('id','name','uuid','language')->get();

        }

    }

    public function links(Request $request) {

        $links = Link::with(['linkable' => function($qu){
            $qu->withoutGlobalScope(LanguageScope::class);
        }])
        ->whereHas('linkable')
        ->whereNotIn('linkable_type',['App\\Models\\Tag'])
        ->get()
        ->filter(function ($link) {
            return $link->linkable->is_published;
        })
        ->map(function($link){

            $title = $link->linkable->name;
            $model = class_basename($link->linkable);

            return [
                'title' => $title,
                'value' => $link->final_uri
            ];
        });

        if( $request->wantsJson() ){

            return $links;

        }

    }


}
