<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Menu;
use App\Models\Scopes\LanguageScope;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;

class MenuController extends Controller
{

    protected $session;

    public function __construct(SessionManager $session) {
        $this->session = $session;
    }

    public function index(Request $request)
    {
        if($request->wantsJson()){
            return Menu::all();
        }

        $this->authorize('viewAny',Menu::class);

        return Inertia('Menu/Index',[
            'menus' => Menu::all(),
            'filters' => [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',Menu::class);

        return Inertia('Menu/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create',Menu::class);

        $request->validate([
            'name' => 'required'
        ]);

        if( $request->location ){
            if( Menu::where('location',$request->location)->where('language',$request->language)->first() ){
                return back()->with('flash',[
                    'type' => 'error',
                    'message' => 'Seçilen lokasyon farklı bir menü tarafından kullanılıyor!'
                ]);
            }
        }

        $menu = Menu::create($request->all());

        session()->forget('core_menus');

        return redirect()->route('menus.index',['language' => $menu->language])->with('flash',[
            "type" => "success",
            "message" => "Menü başarıyla oluşturuldu.",
            "data" => $menu
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $this->authorize('update',Menu::class);

        return Inertia('Menu/Edit',[
            'menu' => $menu,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $this->authorize('update',Menu::class);

        $request->validate([
            'name' => 'required'
        ]);

        if( $request->location ){
            if( Menu::where('location',$request->location)->where('language',$request->language)->where('id','!=',$menu->id)->first() ){
                return back()->with('flash',[
                    'type' => 'error',
                    'message' => 'Seçilen lokasyon farklı bir menü tarafından kullanılıyor!'
                ]);
            }
        }

        $menu->update($request->all());

        session()->forget('core_menus');
        
        return redirect()->route('menus.index',['language' => $menu->language])->with('flash',[
            "type" => "success",
            "message" => "Menü başarıyla güncellendi!",
            "data" => $menu
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $this->authorize('forceDelete',Menu::class);

        $menu->delete();
        return back();
    }


    public function linkableContents(){

        $group_links = Link::with('linkable')
        ->whereHas('linkable')
        ->get()->map(function($item){
            return [
                'id' => $item->id,
                'final_uri' => $item->final_uri,
                'model' => $item->linkable_type,
                'content' => [
                    'id' => $item->linkable_id,
                    'name' => $item->linkable ? $item->linkable->name : null,
                ]
            ];
        })->groupBy('model');

        $linkables = [];

        foreach ($group_links as $key => $items) {
            $linkables[] = [
                'model' => $key,
                'items' => $items
            ];
        }

        return $linkables;

    }


    public static function getCoreMenus(){

        $core_menus = Menu::withoutGlobalScope(LanguageScope::class)->whereNotNull('location')->get();

        $arr = [];

        foreach ($core_menus as $value) {
            $arr[$value['language']][$value['location']] = [
                'location' => $value['location'],
                'language' => $value['language'],
                'items' => $value['tree'],
            ];
        }

        return $arr;

    }

}
