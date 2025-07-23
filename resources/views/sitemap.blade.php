@php
    $xmlStart = '<?xml version="1.0" encoding="UTF-8"?>';
@endphp
{!! $xmlStart !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($data as $item)
    @if ($item->linkable && $item->final_uri)
    @php
        $url = $item->final_uri;
        if($item->linkable->uuid == $settings->home_page){
            if( $item->linkable->language == config('languages.default') ){
                $url = config('app-ea.app_url');
            } else {
                $url = config('app-ea.app_url') .'/'. $item->linkable->language;
            }
        }
    @endphp
    <url>
        <loc>{{ $url }}</loc>
        <lastmod>{{ $item->linkable->updated_at->toAtomString() }}</lastmod>
     </url>
    @endif
    @endforeach
</urlset> 