@if ($isMobile)
<a href="{{$mainPageUri}}">
    @if ($settings->logo['mobile'])
    <img src="{{ $settings->logo['mobile']['original_url'] }}" alt="{{ $settings->site_name }}" width="{{ $settings->logo['mobile']['custom_properties']['width'] }}" height="{{ $settings->logo['mobile']['custom_properties']['height'] }}"/>
    @else
    <span>{{ $settings->site_name }}</span>
    @endif
</a>
@else
<a href="{{$mainPageUri}}">
    @if ($settings->logo['main'])
    <img src="{{ $settings->logo['main']['original_url'] }}" alt="{{ $settings->site_name }}" width="{{ $settings->logo['main']['custom_properties']['width'] }}" height="{{ $settings->logo['main']['custom_properties']['height'] }}"/>
    @else
    <span>{{ $settings->site_name }}</span>
    @endif
</a>
@endif