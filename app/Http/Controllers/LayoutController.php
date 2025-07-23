<?php

namespace App\Http\Controllers;

use App\Models\Layout;
use App\Models\Sidebar;
use Illuminate\Http\Request;

class LayoutController extends Controller
{
    public function index(Request $request)
    {
        if( $request->wantsJson() ){

            return Layout::all();

        }

        $this->authorize('viewAny',Layout::class);

        return Inertia('Layout/Index',[
            'layouts' => Layout::paginate(30),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',Layout::class);

        return Inertia('Layout/Create',[
            'sidebars' => Sidebar::all()->map(function($sidebar){
                return [
                    'id' => $sidebar->id,
                    'name' => $sidebar->name,
                ];
            })
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create',Layout::class);

        $request->validate([
            'name' => 'required',
        ]);

        $layout = Layout::create($request->all());

        return redirect()->route('layouts.index')->with('flash',[
            'type' => 'success',
            'message' => 'Layout oluşturuldu.',
            'data' => $layout
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Layout $layout)
    {
        $this->authorize('viewAny',Layout::class);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Layout $layout)
    {
        $this->authorize('update',Layout::class);

        return Inertia('Layout/Edit',[
            'layout' => $layout,
            'sidebars' => Sidebar::all()->map(function($sidebar){
                return [
                    'id' => $sidebar->id,
                    'name' => $sidebar->name,
                ];
            })
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Layout $layout)
    {
        $this->authorize('update',Layout::class);

        $request->validate([
            'name' => 'required',
        ]);

        $layout->fill($request->all());
        $layout->save();

        return back()->with('flash',[
            'type' => 'success',
            'message' => 'Layout güncellendi.',
            'data' => $layout
        ]);
    }

    public function delete(Layout $layout)
    {
        $this->authorize('delete',Layout::class);

        $layout->delete();
        return back();
    }

    public function restore(Layout $layout)
    {
        $this->authorize('restore',Layout::class);

        $layout->restore();
        return back();
    }

    public function destroy(Layout $layout)
    {
        $this->authorize('forceDelete',Layout::class);

        $layout->forceDelete();
        return back();
    }
}
