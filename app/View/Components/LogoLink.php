<?php

namespace App\View\Components;

use App\Models\Content;
use Closure;
use Illuminate\View\Component;
use App\Settings\GlobalSettings;
use Illuminate\Contracts\View\View;

class LogoLink extends Component
{
    protected $settings;
    public function __construct(GlobalSettings $settings)
    {
        $this->settings = $settings;
    }

    public function render(): View|Closure|string
    {
        $mainPageUri = '/';
        if( config('wholesale.location_is_wholesale') ){
            $wholesale_page = Content::with('uri')->where('uuid',$this->settings->wholesale_page)->first();
            if( $wholesale_page ){
                $mainPageUri = env('APP_URL').'/'.$wholesale_page->uri->link;
            }
        }

        return view('components.logo-link',[
            'mainPageUri' => $mainPageUri,
            'settings' => $this->settings
        ]);
    }
}
