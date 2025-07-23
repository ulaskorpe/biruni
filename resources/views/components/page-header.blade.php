@if ($headerVideo)

    <div class="d-flex min-h-400px align-items-end position-relative pb-4" >
        <video class="bg-video" autoplay muted loop playsinline poster="{{ $headerImage ? $headerImage->original_url : '' }}">
            <source src="{{$headerVideo->original_url}}" type="video/mp4">
        </video>
        <div class="overlay bg-dark opacity-50"></div>
        <div class="container large-container">
            <div class="position-relative">
                @if ($parentTitle)<small class="fs-6 mb-1">{{$parentTitle}}</small>@endif
                <h1 class="position-relative mb-0 title-responsive d-flex flex-column text-white ba-bg-white title-style-three">{{$title}}</h1>
                @if ($subTitle)
            <p class="mb-0 mt-4 p-responsive text-white">{{$subTitle}}</p>
            @endif
            </div>
        </div>
    </div>

@elseif($headerImage)

    <div class="content-section text-center pt-5 pt-xl-7 pb-0 position-relative" id="page-image-header">
        <div class="container position-relative zindex-2">

            <div class="position-relative w-100">
                <h1 class="position-relative mb-0 text-light">{!! $title !!}</h1>
                @if ($subTitle)
                <p class="mb-0 mt-4 text-light">{!! $subTitle !!}</p>
                @endif
            </div>
    
            @if ($breadCrumb)
            <div class="d-none">
                <x-breadcrumb :data="$breadCrumb['data']" :title="$breadCrumb['title']" />
            </div>
            @endif

            <div class="w-xl-75 mt-3 mt-xl-5 mx-auto">
                <img class="img-fluid" src="{{$headerImage->getUrl()}}" alt="{{$title}}" width="{{$headerImage->getCustomProperty('width')}}" height="{{$headerImage->getCustomProperty('height')}}">
            </div>

        </div>
    </div>

@else

    <div @class(['container'])>
    
        <div class="position-relative w-100 py-4">
            <h1 class="position-relative h3 mb-0">{!! $title !!}</h1>
            @if ($subTitle)
            <p class="mb-0 mt-2 text-gray-600">{!! $subTitle !!}</p>
            @endif
        </div>

        @if ($breadCrumb)
        <div class="d-none">
            <x-breadcrumb :data="$breadCrumb['data']" :title="$breadCrumb['title']" />
        </div>
        @endif

    </div>

@endif