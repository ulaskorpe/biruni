<?php

namespace App\Http\Controllers;

use App\Models\Layout;
use App\Models\Taxonomy;
use App\Models\ContentType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PermissionGroup;
use App\Models\SpatiePermission;
use App\Http\Requests\StoreContentTypeRequest;
use App\Http\Requests\UpdateContentTypeRequest;
use App\Models\Scopes\LanguageScope;

class ContentTypeController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(ContentType::class, 'contentType');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if( $request->wantsJson() ){
            
            return ContentType::withoutGlobalScope(new LanguageScope)->select('id','name','language')->with(['contents' => function($q){
                $q->withoutGlobalScope(new LanguageScope)->withoutAppends()->select('id','name','content_type_id','depending_content_id')->with(['uri','depending_content']);
            }])->with(['categories' => function($qu){
                $qu->withoutGlobalScope(new LanguageScope)->withoutAppends()->select('id','name','content_type_id')->with('uri');
            }])->get()->map(function($row){
                return [
                    'id' => $row->id,
                    'name' => $row->name.' - '.$row->language,
                    'categories' => $row->categories,
                    'contents' => $row->contents->map(function($con){
                        return [
                            'id' => $con->id,
                            'name' => $con->depending_content ? $con->name.' - '.$con->depending_content->name : $con->name,
                            'content_type_id' => $con->content_type_id,
                            'uri' => $con->uri
                        ];
                    })
                ];
            });

        }

        return Inertia('ContentType/Index',[
            'layouts' => Layout::all()
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
    public function store(StoreContentTypeRequest $request)
    {
        
        $validated = $request->validated();

        //uuid dolu geldiyse, farkli dilden karsilik giriliyordur. ancak cop kutusunda karsilik dil secimi olabilir. yeni olusturtmayalim.
        if( !empty($request->uuid) ){
            $exists = ContentType::withTrashed()->where('uuid',$request->uuid)->first();

            if($exists){
                return back()->with('flash',[
                    'type' => 'error',
                    'message' => 'Seçilen dil için bağlantılı bir içerik bulunuyor. Lütfen çöp kutusunu kontrol ederek içeriği geri alınız!'
                ]);
            }
        }

        $content_type = ContentType::create($request->all());

        
        if( empty($request->uuid) ){
            $permission_group = PermissionGroup::create([
                'name' => $content_type->name.' Yönetimi',
                'model' => 'Content'
            ]);

            $permissionEk = $content_type->uuid;

            $view = SpatiePermission::create([
                'name' => 'view-'.$permissionEk,
                'view_name' => 'Görüntüle',
                'permission_group_id' => $permission_group->id
            ]);

            $create = SpatiePermission::create([
                'name' => 'create-'.$permissionEk,
                'view_name' => 'Yeni Ekle',
                'permission_group_id' => $permission_group->id
            ]);

            $edit = SpatiePermission::create([
                'name' => 'edit-'.$permissionEk,
                'view_name' => 'Düzenle',
                'permission_group_id' => $permission_group->id
            ]);

            $delete = SpatiePermission::create([
                'name' => 'delete-'.$permissionEk,
                'view_name' => 'Sil',
                'permission_group_id' => $permission_group->id
            ]);
        }

        
        session()->forget('contentTypes');

        return redirect()->route('content-types.index',['language' => $content_type->language])->with('flash',[
            'type' => 'success',
            'message' => 'İçerik tipi oluşturuldu.',
            'data' => $content_type
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(ContentType $contentType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContentType $contentType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContentTypeRequest $request, ContentType $contentType)
    {

        if($request->slug){
            $request->merge([
                'slug' => Str::slug($request->slug)
            ]);
        }

        if($request->taxonomy && $request->use_taxonomy_link){
            $request->merge([
                'taxonomy' => Str::slug($request->taxonomy)
            ]);
        }

        $validated = $request->validated();

        $contentType->fill($request->all());
        $contentType->save();

        if( $contentType->taxonomy && $request->use_taxonomy_link && $contentType->taxonomy->name != $request->taxonomy ){
            $contentType->taxonomy()->update([
                'name' => $request->taxonomy
            ]);
        }

        if( !$contentType->taxonomy && $request->taxonomy && $request->use_taxonomy_link ){

            $new_taxonomy = $request->taxonomy;
            $counter = 1;
            
            while (!Taxonomy::isUnique($new_taxonomy)) {
                $new_taxonomy = $request->taxonomy . '-' . $counter;
                $counter++;
            }

            $taxonomy = new Taxonomy();
            $taxonomy->name = $new_taxonomy;
            $taxonomy->language = $contentType->language;
            $contentType->taxonomy()->save($taxonomy);
        }

        session()->forget('contentTypes');

        return back()->with('flash',[
            'type' => 'success',
            'message' => 'İçerik tipi güncellendi.',
            'data' => $contentType
        ]);
    }

    public function delete(ContentType $contentType)
    {
        $contentType->delete();
        session()->forget('contentTypes');
        return back();
    }

    public function restore(ContentType $contentType)
    {
        $contentType->restore();
        session()->forget('contentTypes');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentType $contentType)
    {
        //
    }

}
