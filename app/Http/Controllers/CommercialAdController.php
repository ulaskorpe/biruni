<?php

namespace App\Http\Controllers;

use App\Models\CommercialAd;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\CommercialAdArea;
use App\Models\Scopes\LanguageScope;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;

class CommercialAdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {

            return CommercialAd::withoutGlobalScope(LanguageScope::class)->get();
        }

        $this->authorize('viewAny', CommercialAd::class);

        $search = $request->search;

        $contents = QueryBuilder::for(CommercialAd::class)
            ->with([
                'commercial_ad_area',
                'main_image'
            ])
            ->when($search && !empty($search), function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')->orWhere('link', 'like', '%' . $search . '%');
                });
            })
            ->defaultSort('order_column')
            ->allowedSorts('name', 'id', 'order_column', 'start_at', 'end_at')
            ->allowedFilters([
                AllowedFilter::callback('areas', function (Builder $query, $value) {
                    $value = array_map('intval', $value);
                    $query->whereIn('commercial_ad_area_id', $value);
                }),
                AllowedFilter::callback('is_published', function (Builder $query, $value) {
                    $query->where('is_published', (int)$value);
                }),
            ])->paginate(30)->withQueryString()->toArray();

        $ad_areas = CommercialAdArea::all();

        return Inertia('CommercialAd/Index', [
            'commercial_ads' => $contents,
            'commercial_ad_areas' => $ad_areas,
            'filters' => [
                'categories' => [
                    'label' => 'Reklam Alanı',
                    'type' => 'select',
                    'options' => $ad_areas->map(function ($st) {
                        return [
                            'label' => $st->name,
                            'value' => (string)$st->id
                        ];
                    }),
                    'value' => $request->filter['areas'] ?? [],
                    'full_width' => true
                ],
                'is_published' => [
                    'label' => 'Yayın Durumu',
                    'type' => 'selectSingle',
                    'options' => [
                        [
                            'label' => 'Yayındakiler',
                            'value' => '1'
                        ],
                        [
                            'label' => 'Yayında Olmayanlar',
                            'value' => '0'
                        ]
                    ],
                    'value' => $request->filter['is_published'] ?? [],
                    'full_width' => true
                ]
            ]
        ]);
    }

    public function trash(Request $request)
    {

        $this->authorize('delete', CommercialAd::class);

        $search = $request->search;

        $contents = QueryBuilder::for(CommercialAd::class)
            ->onlyTrashed()
            ->with([
                'commercial_ad_area',
            ])
            ->when($search && !empty($search), function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')->orWhere('link', 'like', '%' . $search . '%');
                });
            })
            ->allowedFilters([
                AllowedFilter::callback('areas', function (Builder $query, $value) {
                    $value = array_map('intval', $value);
                    $query->whereIn('commercial_ad_area_id', $value);
                }),
                AllowedFilter::callback('is_published', function (Builder $query, $value) {
                    $query->where('is_published', (int)$value);
                }),
            ])->paginate(30)->withQueryString()->toArray();

        $ad_areas = CommercialAdArea::all();

        return Inertia('CommercialAd/Trash', [
            'commercial_ads' => $contents,
            'filters' => [
                'categories' => [
                    'label' => 'Reklam Alanı',
                    'type' => 'select',
                    'options' => $ad_areas->map(function ($st) {
                        return [
                            'label' => $st->name,
                            'value' => (string)$st->id
                        ];
                    }),
                    'value' => $request->filter['areas'] ?? [],
                    'full_width' => true
                ],
                'is_published' => [
                    'label' => 'Yayın Durumu',
                    'type' => 'selectSingle',
                    'options' => [
                        [
                            'label' => 'Yayındakiler',
                            'value' => '1'
                        ],
                        [
                            'label' => 'Yayında Olmayanlar',
                            'value' => '0'
                        ]
                    ],
                    'value' => $request->filter['is_published'] ?? [],
                    'full_width' => true
                ]
            ],
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
        $this->authorize('create', CommercialAd::class);

        $request->validate([
            'name' => ['required', 'string'],
            'link' => 'required',
            'mainImage' => 'required'
        ]);

        $request->merge([
            'start_at' => $request->start_at ? Carbon::parse($request->start_at)->setTimezone('Europe/Istanbul') : null,
            'end_at' => $request->end_at ? Carbon::parse($request->end_at)->setTimezone('Europe/Istanbul') : null,
            'main_image_id' => $request->mainImage['id']
        ]);

        $category = CommercialAd::create($request->all());

        return back()->with('flash', [
            'type' => 'success',
            'message' => 'Reklam oluşturuldu.',
            'data' => $category
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(CommercialAd $commercialAd)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommercialAd $commercialAd)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommercialAd $commercialAd)
    {
        $this->authorize('update', CommercialAd::class);

        $request->validate([
            'name' => ['required', 'string'],
            'link' => 'required',
            'mainImage' => 'required'
        ]);

        $request->merge([
            'start_at' => $request->start_at ? Carbon::parse($request->start_at)->setTimezone('Europe/Istanbul') : null,
            'end_at' => $request->end_at ? Carbon::parse($request->end_at)->setTimezone('Europe/Istanbul') : null,
            'main_image_id' => $request->mainImage['id']
        ]);

        $commercialAd->fill($request->all());
        $commercialAd->save();


        return back()->with('flash', [
            'type' => 'success',
            'message' => 'Seçenek güncellendi.',
            'data' => $commercialAd
        ]);
    }

    public function delete(CommercialAd $commercialAd)
    {
        $this->authorize('delete', CommercialAd::class);

        $commercialAd->delete();
        return back();
    }

    public function restore(CommercialAd $commercialAd)
    {
        $this->authorize('restore', CommercialAd::class);

        $commercialAd->restore();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommercialAd $commercialAd)
    {
        $this->authorize('forceDelete', CommercialAd::class);

        $commercialAd->forceDelete();
        return back();
    }



    public function getReorder(Request $request)
    {

        $this->authorize('update', CommercialAd::class);

        $attributes = QueryBuilder::for(CommercialAd::class)
            ->ordered()
            ->get();

        return Inertia('CommercialAd/ReOrder', [
            'commercial_ads' => $attributes,
            'filters' => [],
        ]);
    }

    public function reorder(Request $request)
    {

        $this->authorize('update', CommercialAd::class);

        CommercialAd::setNewOrder($request->order_data, 10, null, function ($query) {
            $query->withoutGlobalScope(LanguageScope::class);
        });

        $for_language = CommercialAd::withoutGlobalScope(LanguageScope::class)->select('id', 'name', 'language')->where('id', $request->order_data[0])->first();

        return redirect()->route('commercial-ads.index', ['language' => $for_language->language])->with('flash', [
            'type' => 'success',
            'message' => 'Sıralama düzenlendi!'
        ]);
    }



    public function bulkDelete(Request $request)
    {
        $this->authorize('delete', CommercialAd::class);

        $contents = CommercialAd::whereIn('id', $request->items)->get();
        $contents->each->delete();
        return back()->with('flash', [
            'type' => 'success',
            'message' => "Seçilen içerikler silindi!"
        ]);
    }

    public function bulkRestore(Request $request)
    {
        $this->authorize('restore', CommercialAd::class);

        $contents = CommercialAd::onlyTrashed()->whereIn('id', $request->items)->get();
        $contents->each->restore();
        return back()->with('flash', [
            'type' => 'success',
            'message' => "Seçilen içerikler geri alındı!"
        ]);
    }

    public function bulkDestroy(Request $request)
    {
        $this->authorize('forceDelete', CommercialAd::class);

        $contents = CommercialAd::onlyTrashed()->whereIn('id', $request->items)->get();
        $contents->each->forceDelete();
        return back()->with('flash', [
            'type' => 'success',
            'message' => "Seçilen içerikler silindi!"
        ]);
    }


    public function publish(Request $request, CommercialAd $commercialAd)
    {
        $this->authorize('publish', CommercialAd::class);

        $commercialAd->is_published = true;
        $commercialAd->save();

        return back()->with('flash', [
            'type' => 'success',
            'message' => __('Kayıt yayına alındı!')
        ]);
    }

    public function unpublish(CommercialAd $commercialAd)
    {
        $this->authorize('publish', CommercialAd::class);

        $commercialAd->is_published = false;
        $commercialAd->save();

        return back()->with('flash', [
            'type' => 'success',
            'message' => __('Kayıt yayından kaldırıldı!')
        ]);
    }


    public function click(Request $request, CommercialAd $commercialAd) {

        $commercialAd->increment('click_count');

        return redirect($commercialAd->link);

    }

}
