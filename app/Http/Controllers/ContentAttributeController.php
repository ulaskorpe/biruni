<?php

namespace App\Http\Controllers;

use App\Models\ContentType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ContentAttribute;
use App\Models\Scopes\LanguageScope;
use App\Models\ContentAttributeValue;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\StoreContentAttributeRequest;
use App\Http\Requests\UpdateContentAttributeRequest;

class ContentAttributeController extends Controller
{
    public function index(Request $request)
    {
        if( $request->wantsJson() ){

            return ContentAttribute::withoutGlobalScope(LanguageScope::class)->get();

        }

        $this->authorize('viewAny', ContentAttribute::class);

        return Inertia('ContentAttribute/Index',[
            'content_attributes' => ContentAttribute::with(['content_types','values','connected_content_attributes'])->paginate(30),
            'content_types' => ContentType::withoutGlobalScope(LanguageScope::class)
            ->select('id','name','uuid','language')
            ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', ContentAttribute::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContentAttributeRequest $request)
    {

        $this->authorize('create', ContentAttribute::class);

        $validated = $request->validated();

        //uuid dolu geldiyse, farkli dilden karsilik giriliyordur. ancak cop kutusunda karsilik dil secimi olabilir. yeni olusturtmayalim.
        if( !empty($request->uuid) ){
            $exists = ContentAttribute::withTrashed()->where('uuid',$request->uuid)->first();

            if($exists){
                return back()->with('flash',[
                    'type' => 'error',
                    'message' => 'Seçilen dil için bağlantılı bir içerik bulunuyor. Lütfen çöp kutusunu kontrol ederek içeriği geri alınız!'
                ]);
            }
        }

        $attribute = ContentAttribute::create($request->all());
        $attribute->content_types()->attach($request->content_types);

        if( !empty($request->values) ){

            foreach ($request->values as $key => $value) {

                if (!empty($value['name'])) {
                    ContentAttributeValue::create([
                        'content_attribute_id' => $attribute->id,
                        'name' => $value['name'],
                        'color_value' => $value['color_value'],
                        'image_uri' => $value['image_uri'],
                        'language' => $request->language
                    ]);
                }
            }

        }
        
        return back()->with('flash',[
            'type' => 'success',
            'message' => 'Seçenek oluşturuldu.',
            'data' => $attribute
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ContentAttribute $contentAttribute)
    {
        $this->authorize('view', ContentAttribute::class);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContentAttribute $contentAttribute)
    {
        $this->authorize('update', ContentAttribute::class);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContentAttributeRequest $request, ContentAttribute $contentAttribute)
    {

        $this->authorize('update', ContentAttribute::class);

        if($request->slug){
            $request->merge([
                'slug' => Str::slug($request->slug)
            ]);
        }
        
        $validated = $request->validated();
        $contentAttribute->fill($request->all());
        $contentAttribute->save();

        $contentAttribute->content_types()->sync($request->content_types);

        //simdi values kismi icin bir kac isimiz var. Once varolanlari guncelleyecegiz. Yeni gelenleri ekleyecegiz. gelen listesinde olmayan eskileri silecegiz.
        $values_arr = [];

        foreach ($request->values as $key => $value) {

            //id bilgisi geldiyse update
            if( !empty($value['id']) ){
                
                ContentAttributeValue::where('content_attribute_id',$contentAttribute->id)
                ->where('id',$value['id'])
                ->update([
                    'name' => $value['name'],
                    'color_value' => $value['color_value'],
                    'image_uri' => $value['image_uri'],
                ]);

                $values_arr[] = $value['id'];

            } else {

                //id bos geldi, name alani bos degilse ekleyelim.
                if (!empty($value['name'])) {
                    
                    $contentAttributeValue = ContentAttributeValue::create([
                        'content_attribute_id' => $contentAttribute->id,
                        'name' => $value['name'],
                        'color_value' => $value['color_value'],
                        'image_uri' => $value['image_uri'],
                        'language' => $contentAttribute->language
                    ]);

                    $values_arr[] = $contentAttributeValue->id;
                }
                
            }
            
        }

        //simdi listede olmayanlari silelim.
        $delete_option_values = ContentAttributeValue::where('content_attribute_id',$contentAttribute->id)->whereNotIn('id',$values_arr)->get();
        $delete_option_values->each->delete();
        
        return back()->with('flash',[
            'type' => 'success',
            'message' => 'Seçenek güncellendi.',
            'data' => $contentAttribute
        ]);
    }


    public function delete(ContentAttribute $contentAttribute)
    {
        $this->authorize('delete', ContentAttribute::class);

        $contentAttribute->delete();
        return back();
    }

    public function restore(ContentAttribute $contentAttribute)
    {
        $this->authorize('restore', ContentAttribute::class);

        $contentAttribute->restore();
        return back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentAttribute $contentAttribute)
    {
        $this->authorize('forceDelete', ContentAttribute::class);
    }



    
    public function getReorder(Request $request) {

        $this->authorize('update', ContentAttribute::class);

        $attributes = QueryBuilder::for(ContentAttribute::class)
            ->ordered()
            ->get();

        return Inertia('ContentAttribute/ReOrder', [
            'content_attributes' => $attributes,
            'filters' => [],
        ]);
    }

    public function reorder(Request $request) {

        $this->authorize('update', ContentAttribute::class);

        ContentAttribute::setNewOrder($request->order_data, 10, null, function ($query) {
            $query->withoutGlobalScope(LanguageScope::class);
        });

        $for_language = ContentAttribute::withoutGlobalScope(LanguageScope::class)->select('id','name','language')->where('id',$request->order_data[0])->first();

        return redirect()->route('content-attributes.index', ['language' => $for_language->language])->with('flash', [
            'type' => 'success',
            'message' => 'Sıralama düzenlendi!'
        ]);
    }
}
