<?php

namespace App\Http\Controllers;

use App\Models\SavedColumn;
use Illuminate\Http\Request;

class SavedColumnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->wantsJson()) {
            return SavedColumn::all();
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

        $savedColumn = SavedColumn::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $savedColumn
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SavedColumn $savedColumn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SavedColumn $savedColumn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SavedColumn $savedColumn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SavedColumn $savedColumn)
    {
        //
    }
}
