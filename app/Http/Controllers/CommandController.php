<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CommandController extends Controller
{
    public function index(){

        return Inertia('Artisan');

    }

    public function execute(Request $request){

        $output = "Command not found!";
        if( array_key_exists($request->command, Artisan::all()) ){
            Artisan::call($request->command);
            $output = Artisan::output();
        }

        return back()->with('redirect_data',$output);

    }
}
