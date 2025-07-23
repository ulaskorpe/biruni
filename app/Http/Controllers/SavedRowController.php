<?php

namespace App\Http\Controllers;

use App\Models\SavedRow;
use Illuminate\Http\Request;

class SavedRowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->wantsJson()) {
            return SavedRow::all();
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

        $savedRow = SavedRow::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $savedRow
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SavedRow $savedRow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SavedRow $savedRow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SavedRow $savedRow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SavedRow $savedRow)
    {
        //
    }
}
