<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Image\Image as SpatieImage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $this->authorize('viewAny', User::class);

        $users = QueryBuilder::for(User::class)
            ->with([
                'roles'
            ])
            ->when($request->input('search'), function ($query, $search) {
                $query->where(function (Builder $q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->defaultSort('-created_at')
            ->allowedSorts('name')
            ->allowedFilters([
                'name',
                'email',
                AllowedFilter::callback('roles', function (Builder $query, $value) {
                    $value = array_map('intval', $value);
                    $query->whereHas('roles', function (Builder $qqq) use ($value) {
                        $qqq->whereIn('id', $value);
                    });
                }),
                AllowedFilter::callback('approval_status', function (Builder $query, $value) {
                    $query->where('approval_status', (int)$value);
                }),
            ])
            ->paginate()
            ->withQueryString();

        return Inertia('User/Index', [
            'users' => $users,
            'filters' => [
                'roles' => [
                    'label' => 'Roller',
                    'type' => 'select',
                    'options' => Role::get()->map(function ($st) {
                        return [
                            'label' => $st->view_name,
                            'value' => (string)$st->id
                        ];
                    }),
                    'value' => $request->filter['roles'] ?? "",
                    'full_width' => true
                ],
                'approval_status' => [
                    'label' => 'Başvuru Durumu',
                    'type' => 'selectSingle',
                    'options' => [
                        [
                            'label' => 'Yeni',
                            'value' => '0'
                        ],
                        [
                            'label' => 'Onaylanmış',
                            'value' => '1'
                        ],
                        [
                            'label' => 'İptal',
                            'value' => '2'
                        ]
                    ],
                    'value' => $request->filter['approval_status'] ?? "",
                    'full_width' => true
                ],
            ],
            'sortables' => ['name', 'email']
        ]);
    }


    public function trash(Request $request)
    {

        $this->authorize('delete', User::class);
        $search = $request->search;

        //kategorisi varsa taxonomy linklidir. bu nedenle paginate gondericez. Yoksa tamamini alip tree gondericez.
        $users = QueryBuilder::for(User::class)
            ->onlyTrashed()
            ->when($search && !empty($search), function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->paginate()
            ->withQueryString();

        return Inertia('User/Trash', [
            'users' => $users,
            'filters' => [],
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia('User/Create', [
            'roles' => Role::select('id','view_name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles' => 'required|array'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'avatar' => $request->avatar,
            'avatar_preview_url' => $request->avatar_preview_url,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type ?? 'member',
            'is_admin' => $request->user_type == 'admin' ? true : false,
        ]);

        $user->assignRole($request->roles);
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->route('users.edit',$user)->with('flash', [
            'type' => 'success',
            'message' => "Kullanıcı oluşturuldu!"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return Inertia('User/Edit', [
            'roles' => Role::select('id','view_name')->get(),
            'user' => $user->loadMissing('roles')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', User::class);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'roles' => 'required|array'
        ]);

        $request->merge([
            'is_admin' => $request->user_type == 'admin' ? true : false,
        ]);

        $user->fill($request->all());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($user->isDirty('approval_status') && $user->approval_status == 1) {
            $user->approved_by = Auth::id();
            $user->approval_date = now();
            $user->is_active = true;
        }

        if ($user->isDirty('approval_status') && $user->approval_status != 1) {
            $user->is_active = false;
        }

        $user->save();

        //Rolleri guncelle. once eskilerini sil
        DB::table('model_has_roles')->where('model_id', $user->id)->delete();

        //Yeni rolleri ekle
        $user->assignRole($request->roles);
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        return back()->with('flash', [
            'type' => 'success',
            'message' => "Kullanıcı başarıyla güncellendi!"
        ]);
    }

    public function delete(User $user)
    {
        $this->authorize('delete', User::class);

        $user->delete();
        return back();
    }

    public function restore(User $user)
    {
        $this->authorize('delete', User::class);

        $user->restore();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', User::class);

        $user->forceDelete();
        return back();
    }


    public function avatar(Request $request, User $user)
    {

        if ($request->hasFile('avatar')) {

            $file = $request->file('avatar');

            if ($file->isValid()) {
                $file_org_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $file_ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

                $width = '';
                $height = '';

                if ($file_ext == 'svg') {

                    $parsed_xml     = simplexml_load_string(file_get_contents($file->getPathName()));
                    $svg_attributes = $parsed_xml->attributes();
                    $width = Str::replace('px', '', (string) $svg_attributes->width);
                    $height = Str::replace('px', '', (string) $svg_attributes->height);
                } else if (in_array($file_ext, ['JPEG', 'JPG', 'jpeg', 'jpg', 'PNG', 'png', 'GIF', 'gif', 'webp', 'WEBP'])) {

                    $height = SpatieImage::load($file)->getHeight();
                    $width = SpatieImage::load($file)->getWidth();
                }

                $user->addMediaFromRequest('avatar')
                    ->usingFileName(Str::slug($file_org_name) . '.' . $file_ext)
                    ->withCustomProperties([
                        'ext' => $file_ext,
                        'width' => $width,
                        'height' => $height,
                    ])
                    ->toMediaCollection('avatar', 'media'); //iilki collection name, ikincisi filesystem. ikincisi olmazsa default env dakini kullaniyor.

                $user->update([
                    'avatar' => $user->getFirstMedia('avatar')->getUrl(),
                    'avatar_preview_url' => $user->getFirstMedia('avatar')->getUrl('preview'),
                ]);

                return $user;
            }
        }
    }


    //BULK
    public function bulkDelete(Request $request)
    {
        $this->authorize('delete', User::class);

        $users = User::whereIn('id', $request->items)->get();
        $users->each->delete();
        return back()->with('flash', [
            'type' => 'success',
            'message' => "Seçilen kullanıcılar çöp kutusuna taşındı!"
        ]);
    }
    public function bulkRestore(Request $request)
    {
        $this->authorize('delete', User::class);

        $users = User::onlyTrashed()->whereIn('id', $request->items)->get();
        $users->each->restore();
        return back()->with('flash', [
            'type' => 'success',
            'message' => "Seçilen kullanıcılar geri alındı!"
        ]);
    }
    public function bulkDestroy(Request $request)
    {
        $this->authorize('delete', User::class);

        $users = User::onlyTrashed()->whereIn('id', $request->items)->get();
        $users->each->forceDelete();
        return back()->with('flash', [
            'type' => 'success',
            'message' => "Seçilen kullanıcılar silindi!"
        ]);
    }



}
