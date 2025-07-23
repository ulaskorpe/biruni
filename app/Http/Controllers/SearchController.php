<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use App\Settings\GlobalSettings;
use Spatie\Searchable\ModelSearchAspect;

class SearchController extends Controller
{
    
    public function blog(Request $request){

        $search = $request->search;
        $searchResults = null;

        if( $search ){
            $searchResults = (new Search())
            ->registerModel(Content::class, function(ModelSearchAspect $modelSearchAspect) {
                    $modelSearchAspect
                    ->addSearchableAttribute('name')
                    ->addSearchableAttribute('summary')
                    ->addSearchableAttribute('content')
                    ->where('content_type_id',2)
                    ->with([
                        'content_categories','main_image'
                    ]);
            })
            ->limitAspectResults(50)
            ->search($search);
        }

        return view('search.blog',[
            'searchResults' => $searchResults,
            'queryParam' => $search
        ]);

    }

    public function content(Request $request){

        $lang = $request->language;

        if( !$lang ){
            $lang = config('languages.default');
        }

        app()->setLocale($lang);

        $search = $request->search;
        $searchResults = null;

        if( $search && Str::length($search) > 2){
            $searchResults = (new Search())
            ->registerModel(Content::class, function(ModelSearchAspect $modelSearchAspect) {
                $modelSearchAspect
                ->addSearchableAttribute('name')
                ->addSearchableAttribute('summary')
                ->addSearchableAttribute('content')
                ->select('id','name','language','summary','content_type_id','depending_content_id','additional')
                ->whereHas('uri')
                ->with([
                    'content_type:id,name',
                    'main_image',
                    'depending_content:id,name,depending_content_id',
                    'uri:linkable_id,final_uri',
                    'seo_data:id,title,description,seoable_id'
                ])
                ->where('uuid','!=',app(GlobalSettings::class)->home_page);
            })
            ->search($search);
        }

        seo()->title('Arama Sonuçları: '.$search);
        seo()->description('Arama Sonuçları: '.$search);

        return view('search.content',[
            'searchResults' => $searchResults,
            'queryParam' => $search
        ]);

    }

}
