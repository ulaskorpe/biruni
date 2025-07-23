<?php

namespace App\Http\Controllers;

use App\Models\CardLayout;
use Illuminate\Http\Request;

class CardLayoutController extends Controller
{
    public function index(Request $request)
    {
        if( $request->wantsJson() ){

            return CardLayout::all();

        }

        $this->authorize('viewAny', CardLayout::class);

        return Inertia('CardLayout/Index',[
            'cardLayouts' => CardLayout::paginate(30),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', CardLayout::class);

        return Inertia('CardLayout/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', CardLayout::class);

        $request->validate([
            'name' => 'required',
        ]);

        $layout = CardLayout::create($request->all());

        return redirect()->route('card-layouts.index')->with('flash',[
            'type' => 'success',
            'message' => 'Layout oluşturuldu.',
            'data' => $layout
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(CardLayout $cardLayout)
    {
        $this->authorize('view', CardLayout::class);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CardLayout $cardLayout)
    {
        $this->authorize('update', CardLayout::class);

        return Inertia('CardLayout/Edit',[
            'layout' => $cardLayout
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CardLayout $cardLayout)
    {
        $this->authorize('update', CardLayout::class);

        $request->validate([
            'name' => 'required',
        ]);

        $cardLayout->fill($request->all());
        $cardLayout->save();

        return back()->with('flash',[
            'type' => 'success',
            'message' => 'Layout güncellendi.',
            'data' => $cardLayout
        ]);
    }

    public function delete(CardLayout $cardLayout)
    {
        $this->authorize('delete', CardLayout::class);

        $cardLayout->delete();
        return back();
    }

    public function restore(CardLayout $cardLayout)
    {
        $this->authorize('restore', CardLayout::class);

        $cardLayout->restore();
        return back();
    }

    public function destroy(CardLayout $cardLayout)
    {
        $this->authorize('forceDelete', CardLayout::class);

        $cardLayout->forceDelete();
        return back();
    }
}
