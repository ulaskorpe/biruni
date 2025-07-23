<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use App\Settings\GlobalSettings;

class SitemapController extends Controller
{
    
    public function index(Request $request, GlobalSettings $settings){

        $data = Link::with(['linkable' => function($query){
            $query->withoutTrashed();
        }])->get();

        return response(view('sitemap',[
            'data' => $data,
            'settings' => $settings
        ]), 200, [
            'Content-Type' => 'text/xml'
        ]);

    }

}
