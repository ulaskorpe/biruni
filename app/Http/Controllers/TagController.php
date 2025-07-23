<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        if($request->wantsJson()){
            return Tag::all();
        }

        $this->authorize('viewAny',Tag::class);

        $tags = QueryBuilder::for(Tag::class)
        ->with('connected_tags')
        ->paginate(30)->withQueryString();
        
        return Inertia('Tag/Index',[
            'tags' => $tags,
            'filters' => [],
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
        $this->authorize('create',Tag::class);

        $request->validate([
            'name' => 'required',
        ]);

        $request->merge([
            'language' => $request->language ?? config('languages.default')
        ]);

        $tag = Tag::create($request->all());
        

        if( $request->wantsJson() ){
            return response()->json([
                'success' => true,
                'data' => $tag
            ]);
        }

        return back()->with('flash',[
            'type' => 'success',
            'message' => 'Tag oluşturuldu.',
            'data' => $tag,
            'language' => 'tr'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $this->authorize('update',Tag::class);

        $request->validate([
            'name' => 'required',
        ]);

        $tag->fill($request->all());
        $tag->save();

        return back()->with('flash',[
            'type' => 'success',
            'message' => 'Tag güncellendi.',
            'data' => $tag
        ]);
    }


    public function delete(Tag $tag)
    {
        $this->authorize('delete',Tag::class);

        $tag->delete();
        return back();
    }

    public function restore(Tag $tag)
    {
        $this->authorize('delete',Tag::class);

        $tag->restore();
        return back();
    }

    public function destroy(Tag $tag)
    {
        $this->authorize('forceDelete',Tag::class);

        $tag->forceDelete();
        return back();
    }


    //BULK
    public function bulkDelete(Request $request)
    {
        $this->authorize('delete',Tag::class);

        $tags = Tag::whereIn('id',$request->items)->delete();
        return back()->with('flash',[
            'type' =>'success',
            'message' => "Seçilen etiketler silindi!"
        ]);
    }

}
