<?php

namespace App\Http\Controllers;

use App\Models\RedirectUri;
use Illuminate\Http\Request;

class RedirectUriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny',RedirectUri::class);

        return Inertia('RedirectUri/Index',[
            'redirect_uris' => RedirectUri::paginate(30),
            'app_url' => config('app-ea.app_url')
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
        $this->authorize('create',RedirectUri::class);

        $request->validate([
            'old' => 'required|unique:redirect_uris',
            'new' => 'required',
            'redirect_type' => 'required',
        ]);

        if( $request->old == $request->new ){
            return back()->with('flash',[
                'type' => 'error',
                'message' => 'URL ve Yönlendirilecek URL aynı olamaz!'
            ]);
        }

        $redirect_uri = RedirectUri::create($request->all());

        return back()->with('flash',[
            'type' => 'success',
            'message' => 'Yönlendirme kuralı oluşturuldu!'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(RedirectUri $redirectUri)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RedirectUri $redirectUri)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RedirectUri $redirectUri)
    {
        $this->authorize('update',RedirectUri::class);

        $request->validate([
            'old' => ['required','unique:redirect_uris,old,'.$redirectUri->id],
            'new' => 'required',
            'redirect_type' => 'required',
        ]);

        if( $request->old == $request->new ){
            return back()->with('flash',[
                'type' => 'error',
                'message' => 'URL ve Yönlendirilecek URL aynı olamaz!'
            ]);
        }

        $redirectUri->update($request->all());

        return back()->with('flash',[
            'type' => 'success',
            'message' => 'Yönlendirme kuralı güncellendi!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RedirectUri $redirectUri)
    {
        $this->authorize('delete',RedirectUri::class);

        $redirectUri->delete();

        return back()->with('flash',[
            'type' => 'success',
            'message' => 'Yönlendirme kuralı silindi!'
        ]);
    }
}
