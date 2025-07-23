@php
    
    $elemData = $element['data'];
    $selectedAttribute = $elemData['attribute'];
    $contentAttribute = null;

    if(!empty($contentAttributes)){
        
        $contentAttribute = Arr::first($contentAttributes, function ($value, $key) use($selectedAttribute) {
            return $value['id'] === $selectedAttribute['id'];
        });

    }

@endphp


@if ($contentAttribute && !empty($contentAttribute['value']))
<div @class(getBaseAndAnimClasses($elemData))>
    @if ($elemData['withLabel'])
        <span class="title-style-five fw-semibold fs-sm mb-1 text-primary">{{ $contentAttribute['name'] }}</span>
    @endif
    @switch($contentAttribute['option_type'])

        @case('youtube')
        <div class="position-relative">
            @if ($content['main_image'])
            <img src="{{$content['main_image']['original_url']}}" class="img-fluid rounded" width="{{$content['main_image']['custom_properties']['width']}}" height="{{$content['main_image']['custom_properties']['height']}}" alt="{{$content['name']}}">
            @endif
            <div class="overlay bg-dark opacity-25 rounded"></div>
            <a href="{{$contentAttribute['value']}}" class="position-absolute top-0 start-0 d-flex w-100 h-100 rounded align-items-center justify-content-center" data-fancybox="{{$content['id']}}">
                <div class="d-flex box-60 bg-primary text-white align-items-center justify-content-center rounded-circle border border-2 border-white">
                    <i class="bi bi-play-fill fs-2"></i>
                </div>
            </a>
        </div>
        @break

        @case('multiselect')
        @foreach ($contentAttribute['value'] as $val)
        {{$val}}{{ !$loop->last ? ', ' : '' }}
        @endforeach
        @break

        @case('image')
        @php
            $imageWidthHeight = getImageWithHeight($contentAttribute['value']);
        @endphp
        <img loading="lazy" src="{{$contentAttribute['value']}}" class="img-fluid" @if (!empty($imageWidthHeight)) width="{{$imageWidthHeight[0]}}" height="{{$imageWidthHeight[0]}}" @endif alt="{{$contentName}}" />
        @break

        @case('reviewSites')
        @if ($contentAttribute['value'] == 'googleReviews')
            <div class="d-flex align-items-center gap-2">
                <span>
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.0857 12.2385C22.0857 11.4936 22.0188 10.7773 21.8947 10.0896H12V14.1583H17.6541C17.4058 15.4667 16.6608 16.5746 15.5434 17.3196V19.9652H18.953C20.9396 18.1314 22.0857 15.4381 22.0857 12.2385Z" fill="#4285F4"/>
                        <path d="M12 22.5059C14.8366 22.5059 17.2148 21.5699 18.953 19.9653L15.5434 17.3198C14.6074 17.9501 13.4135 18.3321 12 18.3321C9.26847 18.3321 6.94762 16.4888 6.1167 14.0056H2.62109V16.7181C4.34979 20.1468 7.89315 22.5059 12 22.5059Z" fill="#34A853"/>
                        <path d="M6.11674 13.9962C5.90662 13.3658 5.78246 12.6973 5.78246 12.0001C5.78246 11.3029 5.90662 10.6343 6.11674 10.0039V7.2915H2.62114C1.90483 8.70503 1.49414 10.3 1.49414 12.0001C1.49414 13.7001 1.90483 15.2951 2.62114 16.7086L5.34312 14.5883L6.11674 13.9962Z" fill="#FBBC05"/>
                        <path d="M12 5.6774C13.5472 5.6774 14.9226 6.21225 16.0209 7.24374L19.0294 4.23523C17.2052 2.53518 14.8366 1.49414 12 1.49414C7.89315 1.49414 4.34979 3.8532 2.62109 7.29149L6.1167 10.0039C6.94762 7.52071 9.26847 5.6774 12 5.6774Z" fill="#EA4335"/>
                    </svg>
                </span>
                <span class="fw-bold opacity-75">Google Reviews</span>
            </div>
        @endif
        @if ($contentAttribute['value'] == 'trustPilot')
            <div class="d-flex align-items-center gap-2">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 48 48" width="48px" height="48px" baseProfile="basic"><path fill="#00b67a" d="M45.023,18.995H28.991L24.039,3.737l-4.968,15.259L3.039,18.98l12.984,9.44l-4.968,15.243 l12.984-9.424l12.968,9.424L32.055,28.42L45.023,18.995z"/><path fill="#005128" d="M33.169,31.871l-1.114-3.451l-8.016,5.819L33.169,31.871z"/></svg>
                </span>
                <span class="fw-bold opacity-75">Trustpilot</span>
            </div>
        @endif
        @break

        @case('starCount')
        @php
            $starHtml = generateStar($contentAttribute['value']);
        @endphp
        {!! $starHtml !!}
        @break

        @default

        <div class="hstack gap-2">
            @if ($contentAttribute['icon_uri'])
                <img loading="lazy" src="{{ $contentAttribute['icon_uri'] }}" alt="{{ $contentAttribute['name'] }}">
            @endif
            <span>{{ $contentAttribute['value'] }}</span>
        </div>
            
    @endswitch
</div>
@endif