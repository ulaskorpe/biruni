User-agent: *
@foreach($data['disallows'] as $disAllow)
Disallow: {{$disAllow}}
@endforeach
@foreach($data['sitemaps'] as $sitemap)
Sitemap: {{$sitemap}}
@endforeach