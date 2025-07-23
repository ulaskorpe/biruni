<?php

namespace App\Http\Middleware;

use App\Models\ContentType;
use Inertia\Middleware;
use App\Settings\GlobalSettings;
use Illuminate\Http\Request;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $current_language = $request->has('language') && in_array($request->language,config('languages.active')) ? $request->language : config('languages.default');
        $content_types = [];

        if(session()->has('contentTypes') && now() < session('contentTypes')['expire'] && $current_language == session('contentTypes')['curr_lang']){
            $content_types = session('contentTypes')['data'];
        } else {
            $contentTypes = ContentType::with(['taxonomy','connected_content_types'])->get();

            session()->put('contentTypes',[
                'data' => $contentTypes->toArray(),
                'expire' => now()->addMinutes(15), //15dk sonra expire olsun.
                'curr_lang' => $current_language
            ]);

            $content_types = $contentTypes->toArray();
        }
        

        $settings = app(GlobalSettings::class);

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => !$request->user() ? null : [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'first_name' => explode(' ',$request->user()->name)[0] ?? '',
                    'email' => $request->user()->email,
                    'avatar' => $request->user()->avatar,
                    'avatar_preview_url' => $request->user()->avatar_preview_url,
                    'permissions' => $request->user()->getPermissionsViaRoles()->pluck(['name']),
                    'is_admin' => $request->user()->is_admin,
                    'is_superadmin' => $request->user()->hasRole('super-admin'),
                ]
            ],
            'csrf_token' => csrf_token(),
            'flash' => fn () => $request->session()->get('flash'),
            'redirect_data' => fn () => $request->session()->get('redirect_data'),
            'queryParams' => $request->query(),
            'contentTypes' => $content_types,
            'enums' => config('enums'),
            'languages' => config('languages'),
            'current_language' => $current_language,
            'settings' => [
                'logo' => $settings->logo
            ],
            'google_api_key' => config('app-ea.google_api_key')
        ]);
        
    }
}