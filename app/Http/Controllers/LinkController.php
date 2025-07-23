<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\RedirectUri;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Scopes\LanguageScope;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $this->authorize('viewAny',Link::class);

        $search = $request->search;

        $links = QueryBuilder::for(Link::class)
        ->with(['linkable' => function($qu){
            $qu->select('id','name','uuid','language')
            ->withoutAppends()
            ->withoutGlobalScope(LanguageScope::class);
        }])
        ->where('linkable_type','!=','App\Models\Tag')
        ->whereHas('linkable')
        ->when($search && !empty($search), function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('final_uri','like','%'.$search.'%')
                ->orWhere(function($qq) use ($search) {
                    $qq->whereHas('linkable',function (Builder $qqq) use ($search) {
                        $qqq->where('name','like','%'.$search.'%');
                    });
                });
            });
        })
        ->allowedFilters([
            AllowedFilter::exact('language'),
            AllowedFilter::callback('linkable_type', function (Builder $query, $value) {
                $query->whereIn('linkable_type',$value);
            }),
        ])
        ->paginate(30)->withQueryString();

        return Inertia('Link/Index',[
            'links' => $links,
            'filters' => [
                'linkable_type' => [
                    'label' => 'Model',
                    'type' => 'select',
                    'options' => [
                        [
                            'label' => 'Content',
                            'value'=> 'App\Models\Content'
                        ],
                        [
                            'label' => 'Content Category',
                            'value'=> 'App\Models\ContentCategory'
                        ]
                    ],
                    'value' => $request->filter['linkable_type'] ?? [],
                ],
                'language' => [
                    'label' => 'Dil',
                    'type' => 'selectSingle',
                    'options' => [
                        [
                            'label' => 'Türkçe',
                            'value'=> 'tr'
                        ],
                        [
                            'label' => 'English',
                            'value'=> 'en'
                        ]
                    ],
                    'value' => $request->filter['language'] ?? [],
                ],
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Link $link)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Link $link)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Link $link)
    {
        $this->authorize('update',Link::class);

        $request->validate([
            'final_uri' => [
                'required',
                Rule::notIn([$link->final_uri]),
                'unique:links,final_uri,'.$link->id
            ]
        ]);

        if( $request->redirect_old ){
            
            $redirect_uri = RedirectUri::create([
                'old' => $link->final_uri,
                'new' => $request->final_uri,
                'redirect_type' => 301
            ]);

        }

        $link->update([
            'final_uri' => $request->final_uri
        ]);

        return back()->with('flash',[
            'type' => 'success',
            'message' => 'URL güncellendi'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        //
    }
}
