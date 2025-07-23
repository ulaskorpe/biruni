<?php

namespace App\Http\Controllers;

use App\Models\SpatieRole;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->wantsJson()){
            return SpatieRole::with('permissions')->get();
        }

        $this->authorize('viewAny',SpatieRole::class);

        return Inertia('Role/Index',[
            'roles' => SpatieRole::with('permissions')->get(),
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
        $this->authorize('create',SpatieRole::class);

        $this->validate($request, [
            'view_name' => ['required','unique:roles'],
            'permission' => ['required','array'],
        ]);
    
        $role = SpatieRole::create([
            'name' => Str::of($request->view_name)->slug(),
            'view_name' => $request->view_name,
            'description' => $request->description
        ]);

        $role->syncPermissions($request->permission);
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    
        return back()->with('flash',[
            'type' => 'success',
            'text' => 'Rol başarıyla oluşturuldu!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SpatieRole $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SpatieRole $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SpatieRole $role)
    {
        $this->authorize('update',SpatieRole::class);

        $this->validate($request, [
            'view_name' => 'required',
            'permission' => ['required','array']
        ]);
    
        $role->view_name = $request->view_name;
        $role->description = $request->description;
        $role->name = Str::of($request->view_name)->slug();
        $role->save();
    
        $role->syncPermissions($request->permission);
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    
        return back()->with('flash',[
            'type' => 'success',
            'text' => 'Role updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SpatieRole $role)
    {
        $this->authorize('forceDelete',SpatieRole::class);

        if($role->users->count() > 0) {
            return back()->with('flash',[
                'type' => 'error',
                'message' => 'Bu rol için atanmış kullanıcılar var. Öncelikle kullanıcıların rollerini kaldırınız!'
            ]);
        }

        if($role->name == 'super-admin') {
            return back()->with('flash',[
                'type' => 'error',
                'message' => 'Süper Admin rolü silinemez!'
            ]);
        }

        $role->delete();

        return back()->with('flash',[
            'type' => 'success',
            'message' => 'Rol başarıyla silindi.'
        ]);
    }
}
