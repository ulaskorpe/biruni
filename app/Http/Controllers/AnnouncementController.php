<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Rules\CheckDateFormat;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->wantsJson() ){
            return Announcement::all();
        }

        $this->authorize('viewAny', Announcement::class);

        return Inertia('Announcement/Index',[
            'announcements' => Announcement::orderBy('id','desc')->with('connected_announcements')->paginate(30),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Announcement::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $this->authorize('create', Announcement::class);
        
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'start_date' => ['required',new CheckDateFormat],
            'end_date' => ['required',new CheckDateFormat]
        ]);

        $announcement = Announcement::create($request->all());

        return back()->with('flash',[
            'type' => 'success',
            'message' => __('Duyuru oluşturuldu.')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        $this->authorize('view', Announcement::class);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        $this->authorize('update', Announcement::class);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        $this->authorize('update', Announcement::class);

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $announcement->update($request->all());

        return back()->with('flash',[
            'type' => 'success',
            'message' => __('Duyuru güncellendi.')
        ]);
    }

    public function delete(Announcement $announcement)
    {
        $this->authorize('delete', Announcement::class);

        $announcement->delete();
        return back();
    }

    public function restore(Announcement $announcement)
    {
        $this->authorize('restore', Announcement::class);

        $announcement->restore();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        $this->authorize('forceDelete', Announcement::class);

        $announcement->forceDelete();
        return back();
    }
}
