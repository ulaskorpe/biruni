<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    
    public function __invoke(Request $request)
    {
        if($request->wantsJson()){

            $search = $request->search;

            $countries = Country::when($search && !empty($search), function($query) use ($search) {
                $query->where('name','like','%'.$search.'%');
            })->get(['id','native as name']);

            return response()->json($countries);

        }
    }
    
    public function states(Request $request, $country_id){

        return response()->json([
            'states' => State::orderBy('name')->where('country_id',$country_id)->get(['id','name'])
        ]);

    }

}
