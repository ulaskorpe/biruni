<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Layout;
use App\Models\Slider;
use App\Models\Content;
use App\Models\SeoData;
use App\Models\ContentType;
use Illuminate\Support\Arr;
use App\Models\HeaderLayout;
use Illuminate\Http\Request;
use App\Rules\CheckDateFormat;
use Illuminate\Support\Carbon;
use App\Models\ContentCategory;
use Illuminate\Validation\Rule;
use App\Services\PageCssExtractor;
use App\Models\Scopes\LanguageScope;
use App\Rules\CheckHourMinuteFormat;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;

class ContentController extends Controller
{

    protected $contentType;
    protected $cssExtractor;

    public function __construct(Request $request, ContentType $contentType, PageCssExtractor $cssExtractor)
    {

        $contentType = ContentType::withoutGlobalScope(LanguageScope::class)->where('id', $request->contentType)->first();
        $user = Auth::user();

        $this->contentType = $contentType;
        $this->cssExtractor = $cssExtractor;
    }


    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        if ($request->user()->cannot('view-' . $this->contentType->uuid)) {
            abort(403);
        }

        //simdi once ing karsilik secilmis olabilir. productType karsi dildeki olacak.
        if ($this->contentType && $this->contentType->language != $request->language) {

            //ilgili dildeki contenti alalim. gelen dil direkt scope da var.
            $connectedContentType = ContentType::where('uuid', $this->contentType->uuid)->first();

            if (!$connectedContentType) {
                return back()->with('flash', [
                    'type' => 'error',
                    'message' => 'Ürün tipi için seçilen dilde içerik bulunmuyor. Öncelikle içerik tipleri menüsünden ürün tipini oluşturun!'
                ]);
            }

            return redirect()->route('contents.index', [
                'contentType' => $connectedContentType->id,
                'language' => $connectedContentType->language
            ]);
        }

        if (!$this->contentType) {
            return redirect()->route('dashboard')->with('flash', [
                'type' => 'error',
                'message' => 'İçerik tipi bulunamadı.'
            ]);
        }

        $contents = [];
        $search = $request->search;

        //kategorisi varsa taxonomy linklidir. bu nedenle paginate gondericez. Yoksa tamamini alip tree gondericez.
        $contents_query = QueryBuilder::for(Content::class)
            ->withoutAppends()
            ->select('id', 'uuid', 'name', 'slug', 'parent_id', 'language', 'depending_content_id','order_column')
            ->with('uri', 'connected_contents', 'depending_content')
            ->when($search && !empty($search), function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')->orWhere('summary', 'like', '%' . $search . '%');
                });
            })
            ->where('content_type_id', $this->contentType->id)
            ->defaultSort('order_column')
            ->allowedSorts('name','id','order_column')
            ->allowedFilters([
                AllowedFilter::callback('categories', function (Builder $query, $value) {
                    $value = array_map('intval', $value);
                    $query->whereHas('content_categories', function (Builder $qqq) use ($value) {
                        $qqq->whereIn('id', $value);
                    });
                }),
                AllowedFilter::callback('depending_content', function (Builder $query, $value) {
                    $value = array_map('intval', $value);
                    $query->whereIn('depending_content_id', $value);
                }),
            ]);


        $filters = [];

        if( $this->contentType->has_category ){
            $filters['categories'] = [
                'label' => 'Kategori',
                'type' => 'select',
                'options' => ContentCategory::select('id', 'name')->where('content_type_id', $this->contentType->id)->get()->map(function ($st) {
                    return [
                        'label' => $st->name,
                        'value' => (string)$st->id
                    ];
                }),
                'value' => $request->filter['categories'] ?? [],
                'full_width' => true
            ];
        }

        if( $this->contentType->depending_content_type_id ){
            $filters['depending_content'] = [
                'label' => 'Bağlı Olduğu İçerik',
                'type' => 'select',
                'options' => Content::select('id', 'name')->where('content_type_id', $this->contentType->depending_content_type_id)->get()->map(function ($st) {
                    return [
                        'label' => $st->name,
                        'value' => (string)$st->id
                    ];
                }),
                'value' => $request->filter['depending_content'] ?? [],
                'full_width' => true
            ];
        }
        

        if ($this->contentType->has_category) {
            $contents = $contents_query->paginate(30)->withQueryString()->toArray();
        } else {
            $contents_not_tree = $contents_query->get();

            $contents = sortArrayByParentId($contents_not_tree->toArray());
        }

        return Inertia('Content/Index', [
            'contents' => $contents,
            'content_type' => $this->contentType->toArray(),
            'filters' => $filters,
        ]);
    }


    public function trash(Request $request)
    {

        if (!$this->contentType) {
            return redirect()->route('dashboard')->with('flash', [
                'type' => 'error',
                'message' => 'İçerik tipi bulunamadı.'
            ]);
        }

        if ($request->user()->cannot('delete-' . $this->contentType->uuid)) {
            abort(403);
        }

        $contents = [];
        $search = $request->search;

        //kategorisi varsa taxonomy linklidir. bu nedenle paginate gondericez. Yoksa tamamini alip tree gondericez.
        $contents_query = QueryBuilder::for(Content::class)
            ->onlyTrashed()
            ->when($search && !empty($search), function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')->orWhere('summary', 'like', '%' . $search . '%');
                });
            })
            ->where('content_type_id', $this->contentType->id);

        if ($this->contentType->has_category) {
            $contents = $contents_query->paginate(30)->withQueryString()->toArray();
        } else {
            $contents_not_tree = $contents_query->get();

            $contents = sortArrayByParentId($contents_not_tree->toArray());
        }

        return Inertia('Content/Trash', [
            'contents' => $contents,
            'content_type' => $this->contentType->toArray(),
            'filters' => [],
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (!$this->contentType) {
            return redirect()->route('dashboard')->with('flash', [
                'type' => 'error',
                'message' => 'İçerik tipi bulunamadı.'
            ]);
        }

        if ($request->user()->cannot('create-' . $this->contentType->uuid)) {
            abort(403);
        }

        //request uuid geldiyse diger dilden olusturuluyordur. burada bir kac islem yapacagiz.
        //uuid varsa ve language kaydi varsa zaten eslenik dil vardir geri gonderecegiz.
        //uuid varsa ve language kaydi yoksa connected_content degerini onyuze atacagiz. otomatik olarak tum alanlar dolu gelecek.

        $copy_content = null;

        if ($request->has('uuid') && $request->has('from_id')) {

            //once kayit varmi bakalim.
            $exists = Content::withTrashed()->where('uuid', $request->uuid)->first(); //scope var language direkt aliyor.
            if ($exists) {
                return back()->with('flash', [
                    'type' => 'error',
                    'message' => 'Seçilen dil için bağlantılı bir içerik bulunuyor. Çöp kutusunu kontrol ederek içeriği geri alabilirsiniz!'
                ]);
            }

            $copy_content_model = Content::withoutGlobalScope(LanguageScope::class)
                ->withoutAppends()
                ->with(['content_type' => function ($pp) {
                    $pp->select('id', 'uuid', 'name', 'language')->withoutGlobalScope(LanguageScope::class);
                }])
                ->where('id', $request->from_id)->first();

            if ($copy_content_model) {

                //simdi talep ilk gediginden contentType tr kaliyor ornegin. Bunu request icinde contentType EN olana redirect etmemiz lazim.
                if ($this->contentType && $this->contentType->language != $request->language) {

                    $from_content_type = ContentType::select('id', 'uuid', 'name', 'language')->where('uuid', $copy_content_model->content_type->uuid)->first();

                    if (!$from_content_type) {
                        return back()->with('flash', [
                            'type' => 'error',
                            'message' => 'Seçilen dil için, içerik tipi oluşturulmamış. Öncelikle içerik tipini oluşturun!'
                        ]);
                    }

                    return redirect()->route('contents.create', [
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

        if ($request->has('copy_id')) {

            //once kayit varmi bakalim.
            $exists = Content::find($request->copy_id); //scope var language direkt aliyor.
            if ($exists) {

                $exists->media_objects = $exists->media_objects;
                $exists->seo = $exists->seo;
                $exists->name = $exists->name . ' - KOPYA';

                $copy_content = $exists->toArray();
            }
        }

        //kalan isler

        $categories = [];
        $contents = [];

        if ($this->contentType->has_category) {
            $categories_not_tree = ContentCategory::withoutAppends()->select('id', 'name', 'parent_id')->where('content_type_id', $this->contentType->id)->get();
            $categories = sortArrayByParentId($categories_not_tree->toArray());
        } else {

            $contents_not_tree = $this->contentType->contents()->withoutAppends()->select('id', 'name', 'parent_id')->get();
            $contents = sortArrayByParentId($contents_not_tree->toArray());
        }

        $content_attributes = [];
        if ($this->contentType->content_attributes) {

            foreach ($this->contentType->content_attributes as $key => $attribute) {
                $data = [
                    'id' => $attribute->id,
                    'name' => $attribute->name,
                    'slug' => $attribute->slug,
                    'option_type' => $attribute->option_type,
                    'values' => $attribute->option_type == 'select' || $attribute->option_type == 'multiselect' ? $attribute->values : [],
                    'value' => null,
                    'icon_uri' => $attribute->icon_uri
                ];

                $content_attributes[] = $data;
            }
        }

        return Inertia('Content/Create', [
            'content_type' => $this->contentType,
            'depending_contents' => $this->contentType->depending_content_type_id ? Content::withoutAppends()->select('id', 'name')->where('content_type_id', $this->contentType->depending_content_type_id)->get() : null,
            'categories' => $categories,
            'contents' => $contents,
            'content_attributes' => $content_attributes,
            'sliders' => Slider::select('id', 'name')->get(),
            'layouts' => Layout::all()->map(function ($layout) {
                return [
                    'id' => $layout->id,
                    'name' => $layout->name,
                ];
            }),
            'headerLayouts' => HeaderLayout::all()->map(function ($layout) {
                return [
                    'id' => $layout->id,
                    'name' => $layout->name,
                ];
            }),
            'copy_content' => $copy_content
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$this->contentType) {
            return back()->with('flash', [
                'type' => 'error',
                'message' => 'İçerik tipi bulunamadı.'
            ]);
        }

        if ($request->user()->cannot('create-' . $this->contentType->uuid)) {
            abort(403);
        }

        $categories_count = ContentCategory::where('content_type_id', $this->contentType->id)->count();

        $validation_data = [
            'name' => 'required|string|max:191',
            'language' => 'required|string|max:3',
            //'content_categories' => [Rule::requiredIf($categories_count > 0)],
            'seo.title' => Rule::requiredIf($this->contentType->has_url),
        ];

        if (count($this->contentType->content_attributes) > 0) {

            foreach ($this->contentType->content_attributes as $key => $attribute) {

                if ($attribute['option_type'] == 'time') {
                    $validation_data['attributes.' . $key . '.value'] = [Rule::requiredIf($attribute['is_required']), new CheckHourMinuteFormat];
                } else if ($attribute['option_type'] == 'date') {
                    $validation_data['attributes.' . $key . '.value'] = [Rule::requiredIf($attribute['is_required']), new CheckDateFormat];
                } else {
                    $validation_data['attributes.' . $key . '.value'] = Rule::requiredIf($attribute['is_required']);
                }
            }
        }

        $request->validate($validation_data);

        $request->merge([
            'content_type_id' => $this->contentType->id,
            'start_date' => $request->start_date ? Carbon::parse($request->start_date)->setTimezone('Europe/Istanbul') : now(),
            'end_date' => $request->end_date ? Carbon::parse($request->start_date)->setTimezone('Europe/Istanbul') : null,
            'pivot_data' => [
                'media_objects' => $request->media_objects,
                'seo_data' => $request->seo
            ]
        ]);

        $content = Content::create($request->all());

        if ($request->content_categories) {
            $content->content_categories()->attach($request->content_categories);
        }

        if ($request->tags) {
            $content->tags()->attach($request->tags);
        }

        if ($request->media_objects) {
            if ($request->media_objects['mainImage']) {
                $content->main_image()->attach($request->media_objects['mainImage']['id']);
            }
            if ($request->media_objects['headerImage']) {
                $content->header_image()->attach($request->media_objects['headerImage']['id']);
            }
            if ($request->media_objects['mainVideo']) {
                $content->main_video()->attach($request->media_objects['mainVideo']['id']);
            }
            if ($request->media_objects['galleryImages']) {
                $content->gallery_images()->attach(Arr::pluck($request->media_objects['galleryImages'], 'id'));
            }
        }

        if ($this->contentType->has_url) {
            $seo = new SeoData();
            $seo->title = $request->seo['title'];
            $seo->description = $request->seo['description'];
            $content->seo_data()->save($seo);
        }

        //breadcrumb
        $bc = saveBreadCrumb($content);

        return redirect()->route('contents.index', ['contentType' => $this->contentType->id, 'language' => $content->language])->with('flash', [
            'type' => 'success',
            'message' => $this->contentType->name . ' oluşturuldu.',
            //'data' => $content bu alan attribute leri aldigindan ciddi query calistiriyor. gerek yok kapatiyorum.
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Content $content)
    {
        if ($request->user()->cannot('view-' . $content->content_type->uuid)) {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Content $content)
    {
        if ($request->user()->cannot('edit-' . $content->content_type->uuid)) {
            abort(403);
        }

        $categories = [];
        $contents = [];

        if ($content->content_type->has_category) {
            $categories_not_tree = ContentCategory::select('id', 'name', 'language', 'uuid', 'parent_id')->withoutAppends()->where('content_type_id', $content->content_type->id)->get();
            $categories = sortArrayByParentId($categories_not_tree->toArray());
        } else {

            $contents_not_tree = $content->content_type->contents()->select('id', 'name', 'language', 'uuid', 'parent_id')->withoutAppends()->where('id', '!=', $content->id)->get();
            $contents = sortArrayByParentId($contents_not_tree->toArray());
        }

        $content_attributes = [];

        if ($content->content_type->content_attributes) {

            foreach ($content->content_type->content_attributes as $key => $attribute) {

                $current_value = null;

                if ($content->attributes) {
                    $current = Arr::first($content->attributes, function ($value, $key) use ($attribute) {
                        return $value['id'] == $attribute->id;
                    });

                    if ($current) {
                        $current_value = formatOptionType($current['value'], $current['option_type']);
                    }
                }

                $data = [
                    'id' => $attribute->id,
                    'name' => $attribute->name,
                    'slug' => $attribute->slug,
                    'option_type' => $attribute->option_type,
                    'values' => $attribute->option_type == 'select' || $attribute->option_type == 'multiselect' ? $attribute->values : [],
                    'value' => $current_value,
                    'icon_uri' => $attribute->icon_uri
                ];

                $content_attributes[] = $data;
            }
        }

        $content->media_objects = $content->media_objects;

        $content->media_objects = [
            'mainImage' => $content->main_image->count() > 0 ? $content->main_image[0] : null,
            'headerImage' => $content->header_image->count() > 0 ? $content->header_image[0] : null,
            'mainVideo' => $content->main_video->count() > 0 ? $content->main_video[0] : null,
            'galleryImages' => $content->gallery_images
        ];

        $content->seo = [
            'title' => $content->seo_data ? $content->seo_data->title : "",
            'description' => $content->seo_data ? $content->seo_data->description : ""
        ];

        return Inertia('Content/Edit', [
            'content_type' => $content->content_type,
            'depending_contents' => $content->content_type->depending_content_type_id ? Content::withoutAppends()->select('id', 'name')->where('content_type_id', $content->content_type->depending_content_type_id)->get() : null,
            'categories' => $categories,
            'contents' => $contents,
            'content' => $content->loadMissing(['tags', 'content_categories'])->toArray(),
            'sliders' => Slider::select('id', 'name')->get(),
            'content_attributes' => $content_attributes,
            'layouts' => Layout::all()->map(function ($layout) {
                return [
                    'id' => $layout->id,
                    'name' => $layout->name,
                ];
            }),
            'headerLayouts' => HeaderLayout::all()->map(function ($layout) {
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
    public function update(Request $request, Content $content)
    {
        if ($request->user()->cannot('edit-' . $content->content_type->uuid)) {
            abort(403);
        }

        $categories_count = ContentCategory::where('content_type_id', $content->content_type->id)->count();

        $validation_data = [
            'name' => 'required|string|max:191',
            'language' => 'required|string|max:3',
            //'content_categories' => [Rule::requiredIf($categories_count > 0)],
            'seo.title' => Rule::requiredIf($content->content_type->has_url),
            'attributes.*.value' => Rule::requiredIf(count($content->content_type->content_attributes) > 0),
        ];

        if (count($content->content_type->content_attributes) > 0) {

            foreach ($content->content_type->content_attributes as $key => $attribute) {

                if ($attribute['option_type'] == 'time') {
                    $validation_data['attributes.' . $key . '.value'] = [Rule::requiredIf($attribute['is_required']), new CheckHourMinuteFormat];
                } else if ($attribute['option_type'] == 'date') {
                    $validation_data['attributes.' . $key . '.value'] = [Rule::requiredIf($attribute['is_required']), new CheckDateFormat];
                } else {
                    $validation_data['attributes.' . $key . '.value'] = Rule::requiredIf($attribute['is_required']);
                }
            }
        }

        $request->validate($validation_data);

        $current_parent_id = $content->parent_id;

        $request->merge([
            'start_date' => $request->start_date ? Carbon::parse($request->start_date)->setTimezone('Europe/Istanbul') : now(),
            'end_date' => $request->end_date ? Carbon::parse($request->start_date)->setTimezone('Europe/Istanbul') : null,
            'pivot_data' => [
                'media_objects' => $request->media_objects,
                'seo_data' => $request->seo
            ]
        ]);


        //eger parent_id degistiyse ve bu arkasin altinda bir yere geldiyse, normalde parent id si bu arkadas olan bir uste cikmali.
        if ($request->parent_id != $current_parent_id) {
            $parent_degistir = Content::where('parent_id', $content->id)->update([
                "parent_id" => $current_parent_id ?? null
            ]);
        }

        $content->update($request->all());

        $content->content_categories()->detach();
        $content->tags()->detach();
        $content->main_image()->detach();
        $content->main_video()->detach();
        $content->header_image()->detach();
        $content->gallery_images()->detach();

        if ($request->content_categories) {
            $content->content_categories()->attach($request->content_categories);
        }

        if ($request->tags) {
            $content->tags()->attach($request->tags);
        }

        if ($request->media_objects) {
            if ($request->media_objects['mainImage']) {
                $content->main_image()->attach($request->media_objects['mainImage']['id']);
            }
            if ($request->media_objects['headerImage']) {
                $content->header_image()->attach($request->media_objects['headerImage']['id']);
            }
            if ($request->media_objects['mainVideo']) {
                $content->main_video()->attach($request->media_objects['mainVideo']['id']);
            }
            if ($request->media_objects['galleryImages']) {
                $content->gallery_images()->attach(Arr::pluck($request->media_objects['galleryImages'], 'id'));
            }
        }

        //SEO
        if ($content->content_type->has_url) {
            if ($content->seo_data) {
                $content->seo_data()->update([
                    'title' => $request->seo['title'],
                    'description' => $request->seo['description'],
                ]);
            } else {
                $seo = new SeoData();
                $seo->title = $request->seo['title'];
                $seo->description = $request->seo['description'];
                $content->seo_data()->save($seo);
            }

            //sonradan icerik tipine url kullanimi eklenmis olabilir.
            if( $content->content_type->has_url && !$content->uri ) {
                $link = new Link();
                generateUri($content,$link,false,$request->category_for_uri ?? null);
            }
        }

        //breadcrumb
        $bc = saveBreadCrumb($content);

        // if( $content->content_type->has_url ){
        //     $pageUrl = 'http://biruni.localhost';
        //     $css = $this->cssExtractor->processPage($pageUrl);
        //     if( $css ){
        //         $content->css = $css;
        //         $content->save();
        //     }
        // }

        return back()->with('flash', [
            'type' => 'success',
            'message' => 'İçerik güncellendi.',
            //'data' => $content->toArray()
        ]);
    }


    public function delete(Request $request, Content $content)
    {
        if ($request->user()->cannot('delete-' . $content->content_type->uuid)) {
            abort(403);
        }

        $content->delete();
        return back();
    }

    public function restore(Request $request, Content $content)
    {
        if ($request->user()->cannot('delete-' . $content->content_type->uuid)) {
            abort(403);
        }

        $content->restore();
        return back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Content $content)
    {
        if ($request->user()->cannot('delete-' . $content->content_type->uuid)) {
            abort(403);
        }

        $content->forceDelete();
        return back();
    }



    public function getReorder(Request $request)
    {

        if (!$this->contentType) {
            return back()->with('flash', [
                'type' => 'error',
                'message' => 'İçerik tipi bulunamadı.'
            ]);
        }

        if ($request->user()->cannot('view-' . $this->contentType->uuid)) {
            abort(403);
        }

        $contents = QueryBuilder::for(Content::class)
            ->withoutAppends()
            ->where('content_type_id', $this->contentType->id)
            ->ordered()
            ->allowedFilters([
                AllowedFilter::callback('categories', function (Builder $query, $value) {
                    $value = array_map('intval', $value);
                    $query->whereHas('content_categories', function (Builder $qqq) use ($value) {
                        $qqq->whereIn('id', $value);
                    });
                }),
            ])->get();

        return Inertia('Content/ReOrder', [
            'contents' => $contents,
            'content_type' => $this->contentType,
            'filters' => $this->contentType->has_category ? [
                'categories' => [
                    'label' => 'Kategori',
                    'type' => 'select',
                    'options' => ContentCategory::select('id', 'name')->where('content_type_id', $this->contentType->id)->get()->map(function ($st) {
                        return [
                            'label' => $st->name,
                            'value' => (string)$st->id
                        ];
                    }),
                    'value' => $request->filter['categories'] ?? [],
                    'full_width' => true
                ],
            ] : null,
        ]);
    }

    public function reorder(Request $request)
    {

        if (!$this->contentType) {
            return back()->with('flash', [
                'type' => 'error',
                'message' => 'İçerik tipi bulunamadı.'
            ]);
        }

        if ($request->user()->cannot('view-' . $this->contentType->uuid)) {
            abort(403);
        }

        Content::setNewOrder($request->order_data, 10, null, function ($query) {
            $query->where('content_type_id', $this->contentType->id);
        });

        return redirect()->route('contents.index', ['contentType' => $this->contentType->id, 'language' => $request->language])->with('flash', [
            'type' => 'success',
            'message' => 'Sıralama düzenlendi!'
        ]);
    }

    //BULK
    public function bulkDelete(Request $request)
    {
        if ($request->user()->cannot('delete-' . $this->contentType->uuid)) {
            abort(403);
        }

        $contents = Content::whereIn('id', $request->items)->get();
        $contents->each->delete();
        return back()->with('flash', [
            'type' => 'success',
            'message' => "Seçilen içerikler silindi!"
        ]);
    }

    public function bulkRestore(Request $request)
    {
        if ($request->user()->cannot('delete-' . $this->contentType->uuid)) {
            abort(403);
        }

        $contents = Content::onlyTrashed()->whereIn('id', $request->items)->get();
        $contents->each->restore();
        return back()->with('flash', [
            'type' => 'success',
            'message' => "Seçilen içerikler geri alındı!"
        ]);
    }

    public function bulkDestroy(Request $request)
    {
        if ($request->user()->cannot('delete-' . $this->contentType->uuid)) {
            abort(403);
        }

        $contents = Content::onlyTrashed()->whereIn('id', $request->items)->get();
        $contents->each->forceDelete();
        return back()->with('flash', [
            'type' => 'success',
            'message' => "Seçilen içerikler silindi!"
        ]);
    }
}
