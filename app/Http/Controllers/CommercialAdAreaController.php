<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommercialAdArea;
use Spatie\QueryBuilder\QueryBuilder;

class CommercialAdAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {

            return CommercialAdArea::get();
        }

        $this->authorize('viewAny', CommercialAdArea::class);

        $contents = QueryBuilder::for(CommercialAdArea::class)
            ->withCount([
                'commercial_ads',
            ])->get();

        return Inertia('CommercialAdArea/Index', [
            'commercial_ad_areas' => $contents,
            'filters' => []
        ]);
    }


    public function trash(Request $request)
    {

        $this->authorize('delete', CommercialAdArea::class);

        $contents = QueryBuilder::for(CommercialAdArea::class)
            ->onlyTrashed()
            ->paginate(30)->withQueryString()->toArray();

        return Inertia('CommercialAdArea/Trash', [
            'commercial_ad_areas' => $contents,
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
        $this->authorize('create', CommercialAdArea::class);

        $request->validate([
            'name' => ['required', 'string']
        ]);

        $category = CommercialAdArea::create($request->all());

        return back()->with('flash', [
            'type' => 'success',
            'message' => 'Reklam alanı oluşturuldu.',
            'data' => $category
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(CommercialAdArea $commercialAdArea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommercialAdArea $commercialAdArea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommercialAdArea $commercialAdArea)
    {
        $this->authorize('update', CommercialAdArea::class);

        $request->validate([
            'name' => ['required', 'string'],
        ]);

        $commercialAdArea->fill($request->all());
        $commercialAdArea->save();

        return back()->with('flash', [
            'type' => 'success',
            'message' => 'Reklam alanı güncellendi.',
            'data' => $commercialAdArea
        ]);
    }

    public function delete(CommercialAdArea $commercialAdArea)
    {
        $this->authorize('delete', CommercialAdArea::class);

        $commercialAdArea->delete();
        return back();
    }

    public function restore(CommercialAdArea $commercialAdArea)
    {
        $this->authorize('restore', CommercialAdArea::class);

        $commercialAdArea->restore();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommercialAdArea $commercialAdArea)
    {
        $this->authorize('forceDelete', CommercialAdArea::class);

        $commercialAdArea->forceDelete();
        return back();
    }
}
