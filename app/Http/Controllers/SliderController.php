<?php

namespace App\Http\Controllers;

use App\Models\Slider;

use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if($request->wantsJson()){
            return Slider::with('slides')->get();
        }

        $this->authorize('viewAny',Slider::class);

        return Inertia('Slider/Index',[
            'sliders' => Slider::with('slides')->get(),
        ]);
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
        $this->authorize('create',Slider::class);

        $request->validate([
            'name' => 'required'
        ]);

        $slider = Slider::create($request->all());

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {

        $this->authorize('update',Slider::class);

        $request->validate([
            'name' => 'required'
        ]);

        $slider->update($request->all());

        return back();
    }

    public function delete(Slider $slider)
    {
        $this->authorize('delete',Slider::class);

        $slider->delete();
        return back();
    }

    public function restore(Slider $slider)
    {
        $this->authorize('restore',Slider::class);

        $slider->restore();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        //
    }
}
