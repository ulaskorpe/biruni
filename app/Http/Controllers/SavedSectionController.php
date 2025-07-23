<?php

namespace App\Http\Controllers;

use App\Models\SavedSection;
use Illuminate\Http\Request;

class SavedSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->wantsJson()) {
            return SavedSection::all();
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

        $savedSection = SavedSection::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $savedSection
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SavedSection $savedSection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SavedSection $savedSection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SavedSection $savedSection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SavedSection $savedSection)
    {
        //
    }
}
