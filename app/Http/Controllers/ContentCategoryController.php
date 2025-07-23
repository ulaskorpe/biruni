<?php

namespace App\Http\Controllers;

use App\Models\Layout;
use App\Models\SeoData;
use App\Models\ContentType;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ContentCategory;
use App\Models\Scopes\LanguageScope;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\StoreContentCategoryRequest;
use App\Http\Requests\UpdateContentCategoryRequest;

class ContentCategoryController extends Controller
{

    protected $contentType;
    public function __construct(Request $request, ContentType $contentType)
    {

        $contentType = ContentType::withoutGlobalScope(LanguageScope::class)->where('id', $request->contentType)->first();

        $this->contentType = $contentType;

    }

    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->user()->cannot('view-'.$this->contentType->uuid)) {
            abort(403);
        }

        //simdi once ing karsilik secilmis olabilir. productType karsi dildeki olacak.
        if( $this->contentType && $this->contentType->language != $request->language ){

            //ilgili dildeki contenti alalim. gelen dil direkt scope da var.
            $connectedContentType = ContentType::where('uuid',$this->contentType->uuid)->first();

            if( !$connectedContentType ){
                return back()->with('flash',[
                    'type' => 'error',
                    'message' => 'İçerik tipi için seçilen dilde içerik bulunmuyor. Öncelikle içerik tipleri menüsünden iöerik tipini oluşturun!'
                ]);
            }

            return redirect()->route('content-categories.index',[
                'contentType' => $connectedContentType->id,
                'language' => $connectedContentType->language
            ]);
        }

        if( !$this->contentType ){
            return redirect()->route('dashboard')->with('flash',[
                'type' => 'error',
                'message' => 'İçerik tipi bulunamadı.'
            ]);
        }

        if($request->wantsJson()){
            $categories = ContentCategory::where('content_type_id',$this->contentType->id)
            ->when($request->input('content_type_id') && !empty($request->content_type_id), function ($query) use ($request) {
                $query->where('content_type_id',$request->content_type_id);
            })->get();
            return sortArrayByParentId($categories->toArray());
        };

        $categories = QueryBuilder::for(ContentCategory::class)
        ->select('id','uuid','name','slug','parent_id','language')
        ->with('content_type','uri','connected_categories')
        ->where('content_type_id',$this->contentType->id)
        ->allowedFilters([
            AllowedFilter::exact('content_type_id'),
        ])
        ->ordered()
        ->get();

        
        return Inertia('ContentCategory/Index',[
            'categories' => sortArrayByParentId($categories->toArray()),
            'content_type' => $this->contentType,
            'filters' => [],
        ]);
    }

    public function trash(Request $request)
    {
        if( !$this->contentType ){
            return redirect()->route('dashboard')->with('flash',[
                'type' => 'error',
                'message' => 'İçerik tipi bulunamadı.'
            ]);
        }

        if ($request->user()->cannot('delete-'.$this->contentType->uuid)) {
            abort(403);
        }

        $categories = QueryBuilder::for(ContentCategory::class)
        ->onlyTrashed()
        ->with(['content_type'])
        ->where('content_type_id',$this->contentType->id)
        ->allowedFilters([
            AllowedFilter::exact('content_type_id'),
        ])
        ->get();

        
        return Inertia('ContentCategory/Trash',[
            'categories' => sortArrayByParentId($categories->toArray()),
            'content_type' => $this->contentType,
            'filters' => [],
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
        if( !$this->contentType ){
            return redirect()->route('dashboard')->with('flash',[
                'type' => 'error',
                'message' => 'İçerik tipi bulunamadı.'
            ]);
        }

        if ($request->user()->cannot('create-'.$this->contentType->uuid)) {
            abort(403);
        }

        $copy_content = null;

        if( $request->has('uuid') && $request->has('from_id') ){
            
            //once kayit varmi bakalim.
            $exists = ContentCategory::withTrashed()->where('uuid',$request->uuid)->first(); //scope var language direkt aliyor.
            if( $exists ){
                return back()->with('flash',[
                    'type' => 'error',
                    'message' => 'Seçilen dil için bağlantılı bir içerik bulunuyor!'
                ]);
            }

            $copy_content_model = ContentCategory::withoutGlobalScope(LanguageScope::class)
            ->with(['content_type' => function($pp){
                $pp->select('id','uuid','name','language')->withoutGlobalScope(LanguageScope::class);
            }])
            ->where('id',$request->from_id)->first();

            if($copy_content_model){
                
                //simdi talep ilk gediginden contentType tr kaliyor ornegin. Bunu request icinde contentType EN olana redirect etmemiz lazim.
                if( $this->contentType && $this->contentType->language != $request->language ){

                    $from_content_type = ContentType::select('id','uuid','name','language')->where('uuid',$copy_content_model->content_type->uuid)->first();

                    if( !$from_content_type ){
                        return back()->with('flash',[
                            'type' => 'error',
                            'message' => 'Seçilen dil için, içerik tipi oluşturulmamış. Öncelikle içerik tipini oluşturun!'
                        ]);
                    }

                    return redirect()->route('content-categories.create',[
                        'contentType' => $from_content_type->id,
                        'language' => $from_content_type->language,
                        'uuid' => $request->uuid,
                        'from_id' => $request->from_id
                    ]);
                }

                $copy_content_model->media_objects = $copy_content_model->media_objects;
                $copy_content_model->seo = $copy_content_model->seo;

                $copy_content = $copy_content_model->toArray();
            }

        }
                
        $categories_not_tree = ContentCategory::withoutAppends()->select('id','name','parent_id')->where('content_type_id',$this->contentType->id)->get();
        $categories = sortArrayByParentId($categories_not_tree->toArray());

        return Inertia('ContentCategory/Create',[
            'content_type' => $this->contentType,
            'categories' => $categories,
            'copy_content' => $copy_content,
            'layouts' => Layout::all()->map(function($layout){
                return [
                    'id' => $layout->id,
                    'name' => $layout->name,
                ];
            }),
        ]);

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContentCategoryRequest $request)
    {
        if (!$this->contentType) {
            return back()->with('flash', [
                'type' => 'error',
                'message' => 'İçerik tipi bulunamadı.'
            ]);
        }
        
        if ($request->user()->cannot('create-'.$this->contentType->uuid)) {
            abort(403);
        }

        $validated = $request->validated();
        $category = ContentCategory::create($request->all());

        if($request->media_objects){
            if( $request->media_objects['mainImage'] ){
                $category->main_image()->attach($request->media_objects['mainImage']['id']);
            }
            if( $request->media_objects['headerImage'] ){
                $category->header_image()->attach($request->media_objects['headerImage']['id']);
            }
            if( $request->media_objects['mainVideo'] ){
                $category->main_video()->attach($request->media_objects['mainVideo']['id']);
            }
            if( $request->media_objects['galleryImages'] ){
                $category->gallery_images()->attach(Arr::pluck($request->media_objects['galleryImages'],'id'));
            }
        }

        $seo = new SeoData();
        $seo->title = $request->seo['title'];
        $seo->description = $request->seo['description'];
        $category->seo_data()->save($seo);

        //breadcrumb
        $bc = saveBreadCrumb($category);
        
        return redirect()->route('content-categories.index',['contentType' => $category->content_type_id, 'language' => $category->language])->with('flash',[
            'type' => 'success',
            'message' => 'Kategori oluşturuldu.',
            'data' => $category
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, ContentCategory $contentCategory)
    {
        if ($request->user()->cannot('view-'.$contentCategory->content_type->uuid)) {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, ContentCategory $contentCategory)
    {
        if ($request->user()->cannot('edit-'.$contentCategory->content_type->uuid)) {
            abort(403);
        }

        $categories_not_tree = ContentCategory::withoutAppends()->select('id','name','parent_id')->where('content_type_id',$contentCategory->content_type->id)->get();
        $categories = sortArrayByParentId($categories_not_tree->toArray());

        //bunu yapmadan toArray neden media_objects eklemiyor bir bakalim.
        $contentCategory->media_objects = $contentCategory->media_objects;
        $contentCategory->seo = $contentCategory->seo;

        return Inertia('ContentCategory/Edit',[
            'content_type' => $contentCategory->content_type,
            'categories' => $categories,
            'content_category' => $contentCategory->toArray(),
            'layouts' => Layout::all()->map(function($layout){
                return [
                    'id' => $layout->id,
                    'name' => $layout->name,
                ];
            }),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContentCategoryRequest $request, ContentCategory $contentCategory)
    {
        if ($request->user()->cannot('edit-'.$contentCategory->content_type->uuid)) {
            abort(403);
        }

        if($request->slug){
            $request->merge([
                'slug' => Str::slug($request->slug)
            ]);
        }

        $validated = $request->validated();

        $current_parent_id = $contentCategory->parent_id;

        $contentCategory->fill($request->all());
        
        if ($contentCategory->isDirty('parent_id')) {
            
            //eger parent_id degistiyse ve bu arkasin altinda bir yere geldiyse, normalde parent id si bu arkadas olan bir uste cikmali.
            $parent_degistir = contentCategory::where('parent_id',$contentCategory->id)->update([
                "parent_id" => $current_parent_id ?? null
            ]);

        }

        $contentCategory->save();

        $contentCategory->main_image()->detach();
        $contentCategory->main_video()->detach();
        $contentCategory->header_image()->detach();
        $contentCategory->gallery_images()->detach();

        if($request->media_objects){
            if( $request->media_objects['mainImage'] ){
                $contentCategory->main_image()->attach($request->media_objects['mainImage']['id']);
            }
            if( $request->media_objects['headerImage'] ){
                $contentCategory->header_image()->attach($request->media_objects['headerImage']['id']);
            }
            if( $request->media_objects['mainVideo'] ){
                $contentCategory->main_video()->attach($request->media_objects['mainVideo']['id']);
            }
            if( $request->media_objects['galleryImages'] ){
                $contentCategory->gallery_images()->attach(Arr::pluck($request->media_objects['galleryImages'],'id'));
            }
        }

        if($contentCategory->seo_data){
            $contentCategory->seo_data()->update([
                'title' => $request->seo['title'],
                'description' => $request->seo['description'],
            ]);
        } else {
            $seo = new SeoData();
            $seo->title = $request->seo['title'];
            $seo->description = $request->seo['description'];
            $contentCategory->seo_data()->save($seo);
        }

        //breadcrumb
        $bc = saveBreadCrumb($contentCategory);

        return back()->with('flash',[
            'type' => 'success',
            'message' => 'Kategori güncellendi.',
            'data' => $contentCategory
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, ContentCategory $contentCategory)
    {
        if ($request->user()->cannot('delete-'.$contentCategory->content_type->uuid)) {
            abort(403);
        }

        $contentCategory->delete();
        return back();
    }

    public function restore(Request $request, ContentCategory $contentCategory)
    {
        if ($request->user()->cannot('delete-'.$contentCategory->content_type->uuid)) {
            abort(403);
        }

        $contentCategory->restore();
        return back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, ContentCategory $contentCategory)
    {
        if ($request->user()->cannot('delete-'.$contentCategory->content_type->uuid)) {
            abort(403);
        }

        $contentCategory->forceDelete();
        return back();
    }


    public function getReorder(Request $request)
    {

        if( !$this->contentType ){
            return redirect()->route('dashboard')->with('flash',[
                'type' => 'error',
                'message' => 'İçerik tipi bulunamadı.'
            ]);
        }

        if ($request->user()->cannot('edit-'.$this->contentType->uuid)) {
            abort(403);
        }

        $categories = QueryBuilder::for(ContentCategory::class)
        ->withoutAppends()
        ->where('content_type_id',$this->contentType->id)
        ->ordered()->get();

        return Inertia('ContentCategory/ReOrder',[
            'content_categories' => $categories,
            'content_type' => $this->contentType,
            'filters' => null,
        ]);
    }

    public function reorder(Request $request)
    {

        if( !$this->contentType ){
            return back()->with('flash',[
                'type' => 'error',
                'message' => 'İçerik tipi bulunamadı.'
            ]);
        }

        if ($request->user()->cannot('edit-'.$this->contentType->uuid)) {
            abort(403);
        }

        ContentCategory::setNewOrder($request->order_data, 10, null, function($query) {
            $query->where('content_type_id',$this->contentType->id);
        });

        return redirect()->route('content-categories.index',['contentType' => $this->contentType->id, 'language' => $this->contentType->language])->with('flash',[
            'type' => 'success',
            'message' => 'Sıralama düzenlendi!'
        ]);
    }



    //BULK
    public function bulkDelete(Request $request)
    {
        if ($request->user()->cannot('delete-'.$this->contentType->uuid)) {
            abort(403);
        }

        $contents = ContentCategory::whereIn('id',$request->items)->get();
        $contents->each->delete();
        return back()->with('flash',[
            'type' =>'success',
            'message' => "Seçilen içerikler silindi!"
        ]);
    }

    public function bulkRestore(Request $request)
    {
        if ($request->user()->cannot('delete-'.$this->contentType->uuid)) {
            abort(403);
        }

        $contents = ContentCategory::onlyTrashed()->whereIn('id',$request->items)->get();
        $contents->each->restore();
        return back()->with('flash',[
            'type' =>'success',
            'message' => "Seçilen içerikler geri alındı!"
        ]);
    }

    public function bulkDestroy(Request $request)
    {
        if ($request->user()->cannot('delete-'.$this->contentType->uuid)) {
            abort(403);
        }
        
        $contents = ContentCategory::onlyTrashed()->whereIn('id',$request->items)->get();
        $contents->each->forceDelete();
        return back()->with('flash',[
            'type' =>'success',
            'message' => "Seçilen içerikler silindi!"
        ]);
    }
}
