<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectUppercaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Belirli prefixlere sahip rotalar için middleware'ı atla
        $prefix = $request->segment(1); // Route'un ilk segmentini al

        if (Str::startsWith($prefix, ['fetch'])) {
            return $next($request);
        }
        
        // Orijinal URL'yi al
        $url = $request->fullUrl();
        // Sadece path kısmını küçük harfe çevir
        $lowercasedPath = strtolower($request->path());

        // Eğer path kısmında büyük harf varsa
        if ($request->path() !== $lowercasedPath) {
            // Yeni URL'yi oluştur
            $newUrl = $request->getSchemeAndHttpHost() . '/' . $lowercasedPath;

            // Query parametrelerini ekleyin
            if ($request->getQueryString()) {
                $newUrl .= '?' . $request->getQueryString();
            }

            // 301 ile redirect et
            return redirect()->to($newUrl, 301);
        }

        return $next($request);
    }
}
