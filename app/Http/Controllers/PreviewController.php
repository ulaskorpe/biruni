<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Link;
use App\Models\Content;
use App\Models\FormEntry;
use App\Models\RedirectUri;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\GeneralFormMail;

use App\Settings\GlobalSettings;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Spatie\ResponseCache\Facades\ResponseCache;

class HomeController extends Controller
{

    protected $settings;

    public function __construct(GlobalSettings $settings)
    {
        //$this->middleware('cache.headers:public;max_age=31536000;etag');
        $this->settings = $settings;
    }

    public function index()
    {

        session(['session_language' => config('languages.default')]);
        app()->setLocale(config('languages.default'));

        $content = Content::where('uuid', $this->settings->home_page)->first();

        if (!$content) {
            return "Error!";
        }

        $cacheKey = 'content_' . $content->id . '_relations';

        $contentWithRelations = Cache::remember($cacheKey, now()->addHour(), function () use ($content) {
            $content->loadMissing(['header_layout', 'seo_data', 'slider', 'slider.slides', 'connected_contents']);
            return $content;
        });

        seo()->title($contentWithRelations->seo_data ? $contentWithRelations->seo_data->title : $contentWithRelations->name);
        seo()->description($contentWithRelations->seo_data ? $contentWithRelations->seo_data->description : $contentWithRelations->name);

        View::share('connecteds', $contentWithRelations->connected_contents);

        return view('home', [
            'content' => $contentWithRelations,
            'is_home' => true
        ]);
    }

    public function indexLang(Request $request)
    {

        $lang_path = Str::replace('/', '', $request->getPathInfo());
        session(['session_language' => $lang_path]);
        app()->setLocale($lang_path);

        $content = Content::where('uuid', $this->settings->home_page)->where('language', $lang_path)->first();

        if (!$content) {
            return "Error!";
        }

        $cacheKey = 'content_' . $content->id . '_relations';

        $contentWithRelations = Cache::remember($cacheKey, now()->addHour(), function () use ($content) {
            $content->loadMissing(['header_layout', 'seo_data', 'slider', 'slider.slides', 'connected_contents']);
            return $content;
        });

        seo()->title($contentWithRelations->seo_data ? $contentWithRelations->seo_data->title : $contentWithRelations->name);
        seo()->description($contentWithRelations->seo_data ? $contentWithRelations->seo_data->description : $contentWithRelations->name);

        View::share('connecteds', $contentWithRelations->connected_contents);

        return view('home', [
            'content' => $contentWithRelations
        ]);
    }

    public function handleFe(Request $request)
    {

        $path = $request->url();
        $normalizedUrl = preg_replace('/https?:\/\/(www\.)?/', '', $path);

        if (!session()->has('session_language')) {
            session(['session_language' => config('languages.default')]);
        }

        //redirect listesinde var mi?
        $redirectUri = RedirectUri::where('old', $path)->first();

        if ($redirectUri) {
            return redirect($redirectUri->new, $redirectUri->redirect_type);
        }

        $link = Link::with('linkable')->where('final_uri', 'https://www.' . $normalizedUrl)
            ->orWhere('final_uri', 'https://' . $normalizedUrl)
            ->orWhere('final_uri', 'http://www.' . $normalizedUrl)
            ->orWhere('final_uri', 'http://' . $normalizedUrl)
            ->first();

        if (!$link) {
            seo()->title(404);
            seo()->description('Aradığınız sayfa bulunamadı...');
            return response()->view('404', [], 404);
        }

        session(['session_language' => $link->language]);

        $contentWithoutRelations = $link->linkable;

        if (!$contentWithoutRelations) {

            seo()->title(404);
            seo()->description('Aradığınız sayfa bulunamadı...');
            return response()->view('404', [], 404);
        }


        if ($contentWithoutRelations->uuid == $this->settings->home_page) {
            if ($contentWithoutRelations->language != config('languages.default')) {
                return redirect('/' . $contentWithoutRelations->language, 301);
            }
            return redirect('/', 301);
        }

        app()->setLocale($contentWithoutRelations['language']);

        $model = get_class($link->linkable);

        $cacheSeoKey = $link->id . '_content_' . $contentWithoutRelations->id . '_seo';

        $content = Cache::remember($cacheSeoKey, now()->addHour(), function () use ($contentWithoutRelations) {
            $contentWithoutRelations->loadMissing(['seo_data', 'uri']);
            return $contentWithoutRelations;
        });

        $content->page_title = isset($content['additional']['customTitle']) && $content['additional']['customTitle'] == true ? $content['additional']['customTitleText'] : $content->name;

        seo()->title($content->seo_data ? $content->seo_data->title : $content->name);
        seo()->description($content->seo_data ? $content->seo_data->description : $content->name);

        $cacheKey = $link->id . '_content_' . $content->id . '_relations';

        switch ($model) {

            case 'App\Models\ContentCategory':

                $contentWithRelations = Cache::remember($cacheKey, now()->addHour(), function () use ($content) {
                    $content->loadMissing([
                        'content_type',
                        'layout',
                        'header_layout',
                        'main_image',
                        'header_image',
                        'main_video',
                        'connected_categories'
                    ])->loadCount(['contents' => function ($que) {

                        $que->where(function ($qq) {
                            $qq->whereNull('depending_content_id')->orWhereHas('depending_content');
                        });
                    }]);
                    return $content;
                });

                $layout = $contentWithRelations->category_list_template ? $contentWithRelations->category_list_template->layout : ($contentWithRelations->layout ? 'dynamic' : 'default');

                View::share('connecteds', $contentWithRelations->connected_categories);

                return view('content-category.' . $layout, [
                    'content' => $contentWithRelations
                ]);

            break;

            case 'App\Models\Tag':

                View::share('connecteds', $content->connected_tags);

                return view('tag.default', [
                    'content' => $content
                ]);

            break;

            default:

                $contentWithRelations = Cache::remember($cacheKey, now()->addHour(), function () use ($content) {
                    $content->loadMissing([
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
                        'connected_contents',
                        'depending_content',
                        'depending_contents',
                        'depending_contents.depending_content',
                    ]);
                    return $content;
                });

                if ($contentWithRelations->content_type->layout && $contentWithRelations->content_type->layout->slug == 'blog') {
                    return view('content-layouts.blog', [
                        'content' => $contentWithRelations,
                        'connecteds' => $contentWithRelations->connected_contents
                    ]);
                }

                if ($contentWithRelations->content_type->layout && $contentWithRelations->content_type->layout->slug == 'news') {
                    return view('content-layouts.news', [
                        'content' => $contentWithRelations,
                        'connecteds' => $contentWithRelations->connected_contents
                    ]);
                }

                // $layout = $contentWithRelations->layout || $contentWithRelations->content_type->layout ? 'dynamic' : 'default';
                $layout = $contentWithRelations->layout ? 'dynamic' : 'default';

                View::share('connecteds', $contentWithRelations->connected_contents);

                return view('content-layouts.' . $layout, [
                    'content' => $contentWithRelations
                ]);

                break;
        }
    }

    public function formSubmit(Request $request, Form $form)
    {

        $validation_data = [];
        $messages = [];

        foreach ($form['json_data'] as $key => $input) {

            if ($input['required']) {
                $input_name = $input['itemInputName'];

                $validation_data[$input_name] = 'required';
                $messages[$input_name] = 'Lütffen ' . $input['itemLabel'] . ' alanını boş bırakmayınız.';
            }
        }

        if (count($validation_data) > 0) {
            $request->validate($validation_data, $messages);
        }

        $form_fields = $form->json_data;
        $json_data = $request->all();
        $final_json_data = [];

        foreach ($json_data as $key => $value) {


            $pushValue = [
                'name' => $key,
                'label' => null,
                'value' => $value
            ];

            $labelItem = Arr::first($form_fields, function ($field) use ($key) {
                return $field['itemInputName'] == $key;
            });

            if ($labelItem) {

                $pushValue['label'] = $labelItem['itemLabel'];
            }

            $final_json_data[] = $pushValue;
        }


        //once DB ye yazalim.
        $entry = FormEntry::create([
            'form_id' => $form->id,
            'ip_address' => $request->ip(),
            'json_data' => $final_json_data
        ]);

        try {

            $mail = Mail::to($form->to_email)->cc($form->cc_email)->bcc($form->bcc_email)->send(new GeneralFormMail($form, $entry));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }

        if ($form->success_script) {

            return back()->with('success',$form->success_message)->with('formAfterSubmit',$form->success_script);
        }

        ResponseCache::forget(url()->previous());
        
        return back()->with('success',$form->success_message);
    }

    public function fetchOffcanvasContent(Request $request, $uuid, $language){

        $content = Content::select('id','uuid','name','content','language','content')->where('uuid',$uuid)->where('language',$language)->first();

        if( !$content ){
            return response()->json([
                'html' => '<div class="alert alert-danger">'.__('İçerik bulunamadı').'</div>'
            ]);
        }

        $html = view('html-render.render-containers',[
            'sections' => $content->content
        ])->render();

        return response()->json([
            'html' => $html
        ]);

    }

}
