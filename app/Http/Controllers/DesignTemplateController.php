<?php

namespace App\Http\Controllers;

use App\Models\DesignTemplate;
use Illuminate\Http\Request;

class DesignTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->wantsJson() ){

            return DesignTemplate::all();

        }

        $this->authorize('viewAny',DesignTemplate::class);

        return Inertia('DesignTemplate/Index',[
            'templates' => DesignTemplate::paginate(30),
        ]);
    }

    
    public function create()
    {
        $this->authorize('create',DesignTemplate::class);

        return Inertia('DesignTemplate/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create',DesignTemplate::class);

        $request->validate([
            'name' => 'required',
            'content' => 'required'
        ]);

        $template = DesignTemplate::create($request->all());

        return redirect()->route('design-templates.index')->with('flash',[
            'type' => 'success',
            'message' => 'Template oluşturuldu.',
            'data' => $template
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(DesignTemplate $designTemplate)
    {
        $this->authorize('viewAny',DesignTemplate::class);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DesignTemplate $designTemplate)
    {
        $this->authorize('update',DesignTemplate::class);

        return Inertia('DesignTemplate/Edit',[
            'template' => $designTemplate
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DesignTemplate $designTemplate)
    {
        $this->authorize('update',DesignTemplate::class);

        $request->validate([
            'name' => 'required',
            'content' => 'required'
        ]);

        $designTemplate->fill($request->all());
        $designTemplate->save();

        return back()->with('flash',[
            'type' => 'success',
            'message' => 'Template güncellendi.',
            'data' => $designTemplate
        ]);
    }

    public function delete(DesignTemplate $designTemplate)
    {
        $this->authorize('delete',DesignTemplate::class);

        $designTemplate->delete();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DesignTemplate $designTemplate)
    {
        $this->authorize('forceDelete',DesignTemplate::class);
    }
}
