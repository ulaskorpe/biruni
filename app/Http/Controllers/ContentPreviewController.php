<?php

namespace App\Http\Controllers;

use App\Models\ContentType;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Rules\CheckDateFormat;
use Illuminate\Support\Carbon;
use App\Models\ContentCategory;
use App\Models\ContentPreview;
use Illuminate\Validation\Rule;
use App\Models\Scopes\LanguageScope;
use App\Rules\CheckHourMinuteFormat;

class ContentPreviewController extends Controller
{

    protected $contentType;

    public function __construct(Request $request, ContentType $contentType)
    {
        $contentType = ContentType::withoutGlobalScope(LanguageScope::class)->where('id', $request->contentType)->first();
        $this->contentType = $contentType;
    }

    public function store(Request $request)
    {
        if (!$this->contentType) {
            return back()->with('flash', [
                'type' => 'error',
                'message' => 'İçerik tipi bulunamadı.'
            ]);
        }

        //DB tarafinda yuk olmasin. eski previewlari kaldiralim. medialar felan gitsin.
        $currentPreviews = ContentPreview::all();
        foreach ($currentPreviews as $key => $preview) {
            
            $preview->content_categories()->detach();
            $preview->tags()->detach();
            $preview->main_image()->detach();
            $preview->main_video()->detach();
            $preview->header_image()->detach();
            $preview->gallery_images()->detach();

            $preview->forceDelete();

        }


        $categories_count = ContentCategory::where('content_type_id', $this->contentType->id)->count();

        $validation_data = [
            'name' => 'required|string|max:191',
            'language' => 'required|string|max:3',
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

        $content = ContentPreview::create($request->all());

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

        // if ($this->contentType->has_url) {
        //     $seo = new SeoData();
        //     $seo->title = $request->seo['title'];
        //     $seo->description = $request->seo['description'];
        //     $content->seo_data()->save($seo);
        // }

        //breadcrumb
        // $bc = saveBreadCrumb($content);

        return back()->with('redirect_data', $content->id);
        //return redirect()->route('content-previews.show',$content);
    }


    public function show(Request $request, ContentPreview $contentPreview){

        $contentPreview->loadMissing([
            'content_type',
            'content_categories',
            'layout',
            'header_layout',
            'layout.left_sidebar_details',
            'layout.right_sidebar_details',
            'content_type.layout',
            'content_type.layout.left_sidebar_details',
            'content_type.layout.right_sidebar_details',
            'tags',
            'main_image',
            'header_image',
            'gallery_images',
            'main_video',
            'depending_content',
            'depending_contents',
            'depending_contents.depending_content',
        ]);

        if ($contentPreview->content_type->layout && $contentPreview->content_type->layout->slug == 'blog') {
            return view('content-layouts.blog', [
                'content' => $contentPreview,
            ]);
        }

        if ($contentPreview->content_type->layout && $contentPreview->content_type->layout->slug == 'news') {
            return view('content-layouts.news', [
                'content' => $contentPreview,
            ]);
        }

        $layout = $contentPreview->layout ? 'dynamic' : 'default';

        return view('content-layouts.' . $layout, [
            'content' => $contentPreview
        ]);

    }


}
