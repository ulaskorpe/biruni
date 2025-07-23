<?php

namespace App\Http\Controllers;

use App\Models\Sidebar;
use Illuminate\Http\Request;

class SidebarController extends Controller
{

    public function index(Request $request)
    {
        if( $request->wantsJson() ){

            return Sidebar::all();

        }

        $this->authorize('viewAny',Sidebar::class);

        return Inertia('Sidebar/Index',[
            'sidebars' => Sidebar::paginate(30),
        ]);
    }

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',Sidebar::class);

        return Inertia('Sidebar/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create',Sidebar::class);

        $request->validate([
            'name' => 'required',
            'content' => 'required'
        ]);

        $sidebar = Sidebar::create($request->all());

        return back()->with('flash',[
            'type' => 'success',
            'message' => 'Sidebar oluşturuldu.',
            'data' => $sidebar
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sidebar $sidebar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sidebar $sidebar)
    {
        $this->authorize('update',Sidebar::class);

        return Inertia('Sidebar/Edit',[
            'sidebar' => $sidebar
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sidebar $sidebar)
    {
        $this->authorize('update',Sidebar::class);

        $request->validate([
            'name' => 'required',
            'content' => 'required'
        ]);

        $sidebar->fill($request->all());
        $sidebar->save();

        return back()->with('flash',[
            'type' => 'success',
            'message' => 'Sidebar güncellendi.',
            'data' => $sidebar
        ]);
    }

    public function delete(Sidebar $sidebar)
    {
        $this->authorize('delete',Sidebar::class);

        $sidebar->delete();
        return back();
    }

    public function restore(Sidebar $sidebar)
    {
        $this->authorize('restore',Sidebar::class);

        $sidebar->restore();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sidebar $sidebar)
    {
        $this->authorize('forceDelete',Sidebar::class);

        $sidebar->forceDelete();
        return back();
    }
}
