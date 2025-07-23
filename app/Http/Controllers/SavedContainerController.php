<?php

namespace App\Http\Controllers;

use App\Models\SavedContainer;
use Illuminate\Http\Request;

class SavedContainerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->wantsJson()) {
            return SavedContainer::all();
        }
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
        $request->validate([
            'name' => 'required',
            'json_data' => 'required'
        ]);

        $savedContainer = SavedContainer::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $savedContainer
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SavedContainer $savedContainer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SavedContainer $savedContainer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SavedContainer $savedContainer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SavedContainer $savedContainer)
    {
        //
    }
}
