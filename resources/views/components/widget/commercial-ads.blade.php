@php
    
    $widgetData = $widget['data'];

    $contents_query = \App\Models\CommercialAd::with([
        'commercial_ad_area',
        'main_image',
    ])
    ->when(isset($widgetData['commercial_ad_areas']) && !empty($widgetData['commercial_ad_areas']),function($query) use($widgetData) {
        $query->whereIn('commercial_ad_area_id', $widgetData['commercial_ad_areas']);
    })
    ->when(isset($widgetData['includes']) && !empty($widgetData['includes']),function($query) use($widgetData) {
        $query->whereIn('id',$widgetData['includes']);
    })
    ->when(isset($widgetData['excludes']) && !empty($widgetData['excludes']),function($query) use($widgetData) {
        $query->whereIn('id',$widgetData['excludes']);
    })
    ->when(isset($widgetData['orderBy']),function($query) use($widgetData) {
        $query->orderByRaw($widgetData['orderBy']['value']);
    })
    ->when(!$widgetData['all_items'],function($query) use($widgetData) {
        $query->take($widgetData['itemCount']);
    });

    if($widgetData['all_items']){

        $widgetCacheKey = 'widget_'.$widget['type'].'_'.$widget['id'].'_'.app()->getLocale().'_page_'.request()->input('page') ?? 1;

        $contents = Cache::remember($widgetCacheKey, now()->addHour(), function () use ($contents_query) {
            return $contents_query->paginate(24)->withQueryString();
        });

    } else {

        $widgetCacheKey = 'widget_'.$widget['type'].'_'.$widget['id'].'_'.app()->getLocale();

        $contents = Cache::remember($widgetCacheKey, now()->addHour(), function () use ($contents_query) {
            return $contents_query->get();
        });

    }

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
                @foreach ($contents as $key => $content)
                <div @class(['swiper-slide','d-flex','h-auto','align-items-center'])>

                    <a href="{{route('adclick',$content)}}" rel="nofollow" target="_blank">
                        <img src="{{$content->main_image->original_url}}" alt="{{$content->name}}" class="img-fluid">
                    </a>

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
        
        @default

        <div @class($elemClasses)>

            @php
                $collClasses = ['col'];
                $colAnimation = false;
                $colAnimationClass = "";

                if($widgetData['animOptions'] && $widgetData['animOptions']['use']) {
                    $collClasses[] = 'animate__animated anim-opacity-0';
                    $colAnimation = true;
                    $colAnimationClass = $widgetData['animOptions']['class'];
                }

            @endphp

            @foreach ($contents as $key => $content)

            @php
                $delayClass = 'delay-'.($key * 100).'ms';
            @endphp

            <div @class([implode(' ',$collClasses),$delayClass])@if ($colAnimation) data-animation="{{$colAnimationClass}}" @endif>

                <a href="{{route('adclick',$content)}}" rel="nofollow" target="_blank">
                    <img src="{{$content->main_image->original_url}}" alt="{{$content->name}}" class="img-fluid">
                </a>

            </div>
            @endforeach
        </div>
            
    @endswitch

</div>

@if ($widgetData['all_items'] && $contents->links())
<div class="mt-5 mt-xl-7">
    {{ $contents->links() }}
</div>
@endif