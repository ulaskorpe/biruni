<?php

namespace App\Http\Controllers;

use App\Models\HeaderLayout;
use Illuminate\Http\Request;

class HeaderLayoutController extends Controller
{
    public function index(Request $request)
    {
        if( $request->wantsJson() ){

            return HeaderLayout::all();

        }

        $this->authorize('viewAny',HeaderLayout::class);

        return Inertia('HeaderLayout/Index',[
            'headerLayouts' => HeaderLayout::paginate(30),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',HeaderLayout::class);

        return Inertia('HeaderLayout/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create',HeaderLayout::class);

        $request->validate([
            'name' => 'required',
        ]);

        $layout = HeaderLayout::create($request->all());

        return back()->with('flash',[
            'type' => 'success',
            'message' => 'Layout oluşturuldu.',
            'data' => $layout
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(HeaderLayout $headerLayout)
    {
        $this->authorize('viewAny',HeaderLayout::class);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HeaderLayout $headerLayout)
    {
        $this->authorize('update',HeaderLayout::class);

        return Inertia('HeaderLayout/Edit',[
            'layout' => $headerLayout
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HeaderLayout $headerLayout)
    {
        $this->authorize('update',HeaderLayout::class);

        $request->validate([
            'name' => 'required',
        ]);

        $headerLayout->fill($request->all());
        $headerLayout->save();

        return back()->with('flash',[
            'type' => 'success',
            'message' => 'Layout güncellendi.',
            'data' => $headerLayout
        ]);
    }

    public function delete(HeaderLayout $headerLayout)
    {
        $this->authorize('delete',HeaderLayout::class);

        $headerLayout->delete();
        return back();
    }

    public function restore(HeaderLayout $headerLayout)
    {
        $this->authorize('restore',HeaderLayout::class);

        $headerLayout->restore();
        return back();
    }

    public function destroy(HeaderLayout $headerLayout)
    {
        $this->authorize('destroy',HeaderLayout::class);

        $headerLayout->forceDelete();
        return back();
    }
}
