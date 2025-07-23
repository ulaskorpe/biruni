<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {

        if( !$request->user()->hasRole('super-admin') ){
            return Inertia::render('DashboardNotSuperAdmin');
        }

        $chart_data = [];

        $currentDate = Carbon::now();
        $startDate = $currentDate->subMonths(12);

        return Inertia::render('Dashboard',[
            'chart_data' => $chart_data
        ]);
    }
}
