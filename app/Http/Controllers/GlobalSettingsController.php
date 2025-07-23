<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\ContentType;
use App\Models\Form;
use Illuminate\Http\Request;
use App\Settings\GlobalSettings;
use Illuminate\Support\Facades\Artisan;

class GlobalSettingsController extends Controller
{
    public function index(GlobalSettings $settings)
    {
        // conversionlari silmek icin ekledim. kalsin belki lazim olur.
        // $mediaItems = Media::all();

        // foreach ($mediaItems as $media) {
        //     $mediaPath = public_path('media/' . $media->created_at->year . '/' . $media->created_at->month . '/' . $media->id . '/conversions/');

        //     // Dönüşüm dosyalarını silmek için
        //     $conversionFiles = glob($mediaPath . '*');
        //     foreach ($conversionFiles as $file) {
        //         unlink($file); // Her dönüşüm dosyasını sil
        //     }
        // }


        $this->authorize('viewAny', GlobalSettings::class);

        $settings->refresh();

        return Inertia('Settings/Index', [
            'settings' => $settings,
            'content_types' => ContentType::select('id', 'name')->with(['contents' => function ($query) {
                $query->select('id', 'uuid', 'name', 'content_type_id');
                $query->withoutAppends();
            }])->get(),
            'forms' => Form::select('id','name')->get()
        ]);
    }

    public function update(Request $request, GlobalSettings $settings)
    {

        $this->authorize('update', GlobalSettings::class);

        $settings->site_name = $request->site_name;
        $settings->home_page = $request->home_page;
        $settings->wholesale_page = $request->wholesale_page;
        $settings->shop_page = $request->shop_page;
        $settings->kvkk_page = $request->kvkk_page;
        $settings->membership_page = $request->membership_page;
        $settings->sale_contract_page = $request->sale_contract_page;
        $settings->cookie_policy_page = $request->cookie_policy_page;
        $settings->privacy_page = $request->privacy_page;
        $settings->refund_page = $request->refund_page;
        $settings->payment_delivery_page = $request->payment_delivery_page;
        $settings->logo = $request->logo;
        $settings->scripts = $request->scripts;
        $settings->ecommerce_active = $request->ecommerce_active;
        $settings->iyzico_active = $request->iyzico_active;
        $settings->parasut_active = $request->parasut_active;
        $settings->contact = $request->contact;
        $settings->keys = $request->keys;
        $settings->socials = $request->socials;
        $settings->header_buttons = $request->header_buttons;
        $settings->footer_slogan = $request->footer_slogan;
        $settings->footer_layout = $request->content;
        $settings->footer_form = $request->footer_form;

        $settings->save();

        Artisan::command('settings:clear-cache', function () {
            $this->info("Clearing settings cache...");
        });

        $settings->refresh();
        
        return back()->with('flash', [
            'type' => 'success',
            'message' => 'Site ayarları başarıyla güncellendi.',
            'data' => $settings
        ]);
    }
}
