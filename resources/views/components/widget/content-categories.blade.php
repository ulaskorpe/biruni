@php
    
    $widgetData = $widget['data'];

    $widgetCacheKey = 'widget_'.$widget['type'].'_'.$widget['id'].'_'.app()->getLocale();

    $categories = Cache::remember($widgetCacheKey, now()->addMinutes(10), function () use ($widgetData) {
        return \App\Models\ContentCategory::with([
            'main_image',
            'uri',
        ])
        ->when(isset($widgetData['categories']) && count($widgetData['categories']) > 0, function($query) use ($widgetData) {
            $query->whereIn('id', $widgetData['categories']);
        })
        ->when(isset($widgetData['orderBy']), function($query) use ($widgetData) {
            $query->orderByRaw($widgetData['orderBy']['value']);
        })
        ->get();
    });

    $elemDivClasses = [];

    if($widgetData['baseDesignOptions']['class']) $elemDivClasses[] = $widgetData['baseDesignOptions']['class'];
    if(isset($widgetData['baseDesignOptions']['position'])) $elemDivClasses[] = $widgetData['baseDesignOptions']['position'];

    foreach ($widgetData['baseDesignOptions']['margin'] as $key => $value) {
        if($value) $elemDivClasses[] = $value;
    }
    foreach ($widgetData['baseDesignOptions']['padding'] as $key => $value) {
        if($value) $elemDivClasses[] = $value;
    }

    $elemClasses = [];

    if($widgetData['type'] == 'grid'){
        $elemClasses[] = 'row';
        $elemClasses[] = 'g-3';
        $elemClasses[] = 'row-cols-'.$widgetData['columnCounts']['sm'];
        $elemClasses[] = 'row-cols-md-'.$widgetData['columnCounts']['md'];
        $elemClasses[] = 'row-cols-lg-'.$widgetData['columnCounts']['lg'];
        $elemClasses[] = 'row-cols-xl-'.$widgetData['columnCounts']['xl'];
    }

    if($widgetData['type'] == 'carousel'){
        $elemClasses[] = 'ea-swiper';
        $elemClasses[] = 'swiper';
    }

@endphp

<div @class($elemDivClasses)>

    @switch($widgetData['type'])

        @case('carousel')
        
        <div @class($elemClasses) data-swiper-options="{{$widgetData['swiperOptions']}}">
            <div @class(['swiper-wrapper'])>
                @foreach ($categories as $key => $category)
                <div @class(['swiper-slide','d-flex','h-auto','align-items-center'])>
                    <x-cards.content-category-card :category="$category"/>
                </div>
                @endforeach
            </div>
            @if ($widgetData['pagination'])
            <div class="swiper-pagination"></div>
            @endif
            @if ($widgetData['navigation'])
            <div class="swiper-theme-prev"></div>
            <div class="swiper-theme-next"></div>
            @endif
        </div>

        @break

        @case('horizontal-accordeon')
        
        <div @class($elemClasses)>
            <div class="horizontal-accordeon h-500px gap-1">
            @foreach ($categories as $key => $category)

            @if ($category->main_image->count() > 0)
            <div class="item p-3 p-xl-4" data-bg-image="{{$category->main_image[0]->original_url}}">
                <a class="content title-responsive text-white fw-bold text-decoration-none text-uppercase" href="{{ $category->uri->final_uri }}">
                    {{ $category->name }}
                </a>
            </div>
            @endif

            @endforeach
            </div>
        </div>

        @break
        
        @default

        <div @class($elemClasses)>
            @foreach ($categories as $key => $category)
            <div class="col">
                <x-cards.content-category-card :category="$category"/>
            </div>
            @endforeach
        </div>
            
    @endswitch

</div>