@if ($element)

    @php

        //preload icin buraya tasidim. yani tum html yine javascript icinde
        $elemData = $element['data'];
        $html = $elemData['elemHtml'];

    @endphp

    {!! $html !!}

    @if ($elemData['asPreload'] && $elemData['loading'] != 'lazy')
    @push('preload')
    <link rel="preload" as="image" href="{{$elemData['src']}}" fetchpriority="high">
    @endpush
    @endif

@endif