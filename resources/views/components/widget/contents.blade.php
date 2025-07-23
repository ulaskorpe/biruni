@php
    
    $widgetData = $widget['data'];

    $contents_query = \App\Models\Content::with([
        'content_categories',
        'main_image',
        //'header_image',
        //'main_video',
        //'header_video',
        //'gallery_images',
        'uri',
        'content_type',
        'depending_content',
        'depending_contents'
    ])
    ->when(isset($widgetData['categories']) && !empty($widgetData['categories']),function($query) use($widgetData) {
        $query->whereHas('content_categories',function($cat) use($widgetData) {
            $cat->whereIn('id', $widgetData['categories']);
        });
    })
    ->when(isset($widgetData['includes']) && !empty($widgetData['includes']),function($query) use($widgetData) {
        $query->whereIn('id',$widgetData['includes']);
    })
    ->when(isset($widgetData['only_has_depending_content']) && $widgetData['only_has_depending_content'] === true,function($query) use($widgetData) {
        $query->whereHas('depending_content');
    })
    ->when(isset($widgetData['excludes']) && !empty($widgetData['excludes']),function($query) use($widgetData) {
        $query->whereNotIn('id',$widgetData['excludes']);
    })
    ->when(isset($widgetData['orderBy']),function($query) use($widgetData) {
        $query->orderByRaw($widgetData['orderBy']['value']);
    })
    ->when(!$widgetData['all_content_types'],function($query) use($widgetData) {
        $query->whereIn('content_type_id',$widgetData['content_types']);
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
        $elemClasses[] = 'g-4';
        $elemClasses[] = 'row-cols-'.$widgetData['columnCounts']['sm'];
        $elemClasses[] = 'row-cols-md-'.$widgetData['columnCounts']['md'];
        $elemClasses[] = 'row-cols-lg-'.$widgetData['columnCounts']['lg'];
        $elemClasses[] = 'row-cols-xl-'.$widgetData['columnCounts']['xl'];
        
    } else if($widgetData['type'] == 'carousel'){

        if($widgetData['baseDesignOptions']['class']) $elemClasses[] = $widgetData['baseDesignOptions']['class'];

        $elemClasses[] = 'ea-swiper';
        $elemClasses[] = 'swiper';
        if($widgetData['pagination']) $elemClasses[] = 'pb-5';

    } else {

        if($widgetData['baseDesignOptions']['class']) $elemDivClasses[] = $widgetData['baseDesignOptions']['class'];

    }

    $customLayout = null;
    if(isset($widgetData['cardType']) && $widgetData['cardType'] == 'custom'){
        $cardLayout = \App\Models\CardLayout::find($widgetData['customCardLayout']);
        if( $cardLayout ){
            $customLayout = $cardLayout;
        }
    }

@endphp


<div @class($elemDivClasses)>

    @switch($widgetData['type'])

        @case('carousel')
        
        <div @class($elemClasses) data-swiper-options="{{$widgetData['swiperOptions']}}" id="{{ isset($widgetData['widgetId']) && !empty($widgetData['widgetId']) ? $widgetData['widgetId'] : 'swiper-'.Str::uuid() }}">

            @if ($widgetData['navigation'] && $widgetData['navigationPosition'] == 'navigation-top-right')
            <div class="swiper-navigation-div navigation-top-right no-gutter">
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            @endif

            <div @class(['swiper-wrapper'])>
                @foreach ($contents as $key => $content)
                <div @class(['swiper-slide','d-flex','h-auto','align-items-center'])>

                    @if ($customLayout)
                    <x-cards.dynamic-card :content="$content" :card-layout="$customLayout"/>
                    @else
                    <x-cards.content-card :content="$content"/>
                    @endif

                </div>
                @endforeach
            </div>
            
            @if ($widgetData['pagination'])
            <div class="swiper-pagination"></div>
            @endif

            @if ($widgetData['navigation'] && $widgetData['navigationPosition'] == 'navigation-default')
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            @endif

            @if ($widgetData['navigation'] && $widgetData['navigationPosition'] == 'navigation-bottom-right')
            <div class="swiper-navigation-div no-gutter">
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            @endif

            @if ($widgetData['navigation'] && $widgetData['navigationPosition'] == 'navigation-bottom-left')
            <div class="swiper-navigation-div navigation-bottom-left no-gutter">
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            @endif

        </div>

        @break

        @case('accordeon')
        
        <div @class($elemClasses)>
            @php
                $accId = 'acc-'.Str::uuid();
            @endphp
            <div class="accordion vstack gap-1" id="{{$accId }}">
            @foreach ($contents as $key => $content)
            <div class="accordion-item bg-white rounded-0 border-0">
                <h3 class="accordion-header border-bottom">
                  <button class="accordion-button rounded-0 fw-semibold bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acc-collapse-{{$content->id}}" aria-expanded="true" aria-controls="acc-collapse-{{$content->id}}">
                    {!! $content->name !!}
                  </button>
                </h3>
                <div id="acc-collapse-{{$content->id}}" class="accordion-collapse collapse" data-bs-parent="#{{$accId }}">
                  <div class="accordion-body text-gray-600">
                    {!! $content->summary !!}
                  </div>
                </div>
              </div>
            @endforeach
            </div>
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

                @if ($customLayout)
                <x-cards.dynamic-card :content="$content" :card-layout="$customLayout"/>
                @else
                <x-cards.content-card :content="$content"/>
                @endif

            </div>
            @endforeach
        </div>
            
    @endswitch

</div>

@if ($widgetData['all_items'])
<div class="mt-5 mt-xl-7">
    {{ $contents->links() }}
</div>
@endif