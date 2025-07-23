<?php

namespace App\Http\Controllers;

use App\Models\ContentCategoryListTemplate;
use Illuminate\Http\Request;

class ContentCategoryListTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->wantsJson() ){

            return ContentCategoryListTemplate::all()->map(function($q){
                return [
                    'id' => $q->id,
                    'name'=> $q->name,
                ];
            });

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ContentCategoryListTemplate $contentCategoryListTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContentCategoryListTemplate $contentCategoryListTemplate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContentCategoryListTemplate $contentCategoryListTemplate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentCategoryListTemplate $contentCategoryListTemplate)
    {
        //
    }
}
