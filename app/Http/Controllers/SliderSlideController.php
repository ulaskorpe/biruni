<?php

namespace App\Http\Controllers;

use App\Models\SliderSlide;
use Illuminate\Http\Request;

class SliderSlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        if( $request->user()->cannot('create-Slider') ){
            abort(403);
        }

        $slide = SliderSlide::create($request->all());

        return back()->with('flash',[
            'type' => 'success',
            'message' => 'Slide eklendi',
            'data' => $slide
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SliderSlide $sliderSlide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SliderSlide $sliderSlide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SliderSlide $sliderSlide)
    {

        if( $request->user()->cannot('edit-Slider') ){
            abort(403);
        }

        $sliderSlide->update($request->all());

        return back()->with('flash',[
            'type' => 'success',
            'message' => 'Slide güncellendi.',
            'data' => $sliderSlide->toArray()
        ]);
    }

    public function delete(Request $request, SliderSlide $sliderSlide)
    {
        if( $request->user()->cannot('delete-Slider') ){
            abort(403);
        }

        $sliderSlide->delete();
        return back();
    }

    public function restore(Request $request, SliderSlide $sliderSlide)
    {
        if( $request->user()->cannot('delete-Slider') ){
            abort(403);
        }

        $sliderSlide->restore();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SliderSlide $sliderSlide)
    {
        //
    }


    public function reorder(Request $request)
    {
        if( $request->user()->cannot('edit-Slider') ){
            abort(403);
        }
        
        SliderSlide::setNewOrder($request->data,10);

        return response()->json([
            'status' => 'success'
        ]);
    }


}
