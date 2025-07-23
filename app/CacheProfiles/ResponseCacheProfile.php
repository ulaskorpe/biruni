<?php

namespace App\CacheProfiles;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Spatie\ResponseCache\CacheProfiles\BaseCacheProfile;

class ResponseCacheProfile extends BaseCacheProfile
{
    
    public function useCacheNameSuffix(Request $request): string
    {
        
        return checkIsMobile($request) ? '_mobile' : '_desktop';
    }
    
    public function shouldCacheRequest(Request $request): bool
    {
        if ($request->ajax()) {
            return false;
        }

        if ($this->isRunningInConsole()) {
            return false;
        }

        if( Session::has('success') || Session::has('error') || Session::has('info') || Session::has('formAfterSubmit') ){
            return false;
        }

        return $request->isMethod('get');
    }

    public function shouldCacheResponse(Response $response): bool
    {
        if (! $this->hasCacheableResponseCode($response)) {
            return false;
        }

        if (! $this->hasCacheableContentType($response)) {
            return false;
        }

        if( Session::has('success') || Session::has('error') || Session::has('info') || Session::has('formAfterSubmit') ){
            return false;
        }

        return true;
    }

    public function hasCacheableResponseCode(Response $response): bool
    {
        if ($response->isSuccessful()) {
            return true;
        }

        if ($response->isRedirection()) {
            return true;
        }

        return false;
    }

    public function hasCacheableContentType(Response $response): bool
    {
        $contentType = $response->headers->get('Content-Type', '');

        if (str_starts_with($contentType, 'text/')) {
            return true;
        }

        if (Str::contains($contentType, ['/json', '+json'])) {
            return true;
        }

        return false;
    }
}