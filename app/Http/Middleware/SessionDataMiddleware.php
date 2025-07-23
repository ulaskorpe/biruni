<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\MenuController;
use Symfony\Component\HttpFoundation\Response;

class SessionDataMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if( !session()->has('core_menus') || (session()->has('core_menus') && now() > session()->get('core_menus')['expire']) ){
            session()->put('core_menus',[
                'data' => MenuController::getCoreMenus(),
                'expire' => now()->addMinutes(15),
            ]);

        }

        return $next($request);
    }
}
