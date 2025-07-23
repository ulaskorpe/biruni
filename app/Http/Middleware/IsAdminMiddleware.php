<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next)
    {
        if( !auth()->user() ){
            return redirect()->route('login',['redirect' => $request->path() == 'admin' ? '' : $request->fullUrl()]);
        }

        // if (auth()->user()->is_admin) {
        //     return $next($request);
        // }
        
        //return response()->json('Not authorized!');
        return $next($request);

    }
}
