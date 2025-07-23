<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{

    public function cities(Request $request, $state_id){

        return response()->json([
            'cities' => City::orderBy('name')->where('state_id',$state_id)->get(['id','name'])
        ]);

    }


}
