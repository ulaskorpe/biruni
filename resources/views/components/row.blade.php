@php
    
    $display = true;

    if( $isMobile && !$row['settings']['display']['mobile'] ){
        $display = false;
    }

    if( !$isMobile && !$row['settings']['display']['desktop'] ){
        $display = false;
    }

    $columnsTabOrSlide = $row['settings']['columnAsTabs'] || $row['settings']['columnAsSlides'] ? true : false;

    $classes = [
        $columnsTabOrSlide ? 'w-100' : 'row',
        'position-relative',
        $row['settings']['alignContents'],
        $row['settings']['justifyContents']
    ];

    foreach ($row['settings']['gutter'] as $key => $value) {
        if($value) $classes[] = $value;
    }

    if($row['settings']['class']) $classes[] = $row['settings']['class'];

    foreach ($row['settings']['margin'] as $key => $value) {
        if($value) $classes[] = $value;
    }

    if(isset($row['settings']['rounded'])) $classes[] = $row['settings']['rounded'];

    $masonry = false;
    if(isset($row['settings']['masonry']) && $row['settings']['masonry']){
        $masonry = true;
    }

    $rowId = $isLayout ? 'row_'.Str::uuid() : $row['settings']['id'];

@endphp

@if ( $display )

<div @class($classes) id="{{$rowId}}"@if ($masonry)  data-masonry='{"percentPosition": true }' @endif>

    @if ($row['settings']['background']['color'])
    <div @class(['overlay',$row['settings']['background']['color']])></div>
    @endif

    @if ($row['settings']['background']['image'])
    <div @class(['overlay',$row['settings']['background']['size'],$row['settings']['background']['position']]) data-bg-image="{{$row['settings']['background']['image']}}"></div>
    @endif

    @if ($row['settings']['background']['layer']['color'])
    <div @class(['overlay',$row['settings']['background']['layer']['color'],$row['settings']['background']['layer']['opacity']])></div>
    @endif

    @if (count($row['columns']) > 0)
    
        @if ($row['settings']['columnAsTabs'])

            <ul class="nav nav-pills pb-1 d-inline-flex gap-1 mb-4 border-0" role="tablist">
                @foreach ($row['columns'] as $column)
                <li class="nav-item" role="presentation">
                    <button @class(['nav-link rounded', 'active' => $loop->first]) data-bs-toggle="tab" data-bs-target="#{{$column['settings']['id']}}" type="button" role="tab" aria-controls="{{$column['settings']['id']}}" aria-selected="true">{!! $column['settings']['name'] !!}</button>
                </li>
                @endforeach
            </ul>

            <div class="tab-content w-100">
                @foreach ($row['columns'] as $column)
                <div @class(['tab-pane','show active' => $loop->first]) id="{{$column['settings']['id']}}" role="tabpanel" tabindex="0">
                    <x-column :column="$column" :content="$content" :tabOrSlideDiv="$columnsTabOrSlide" :is-layout="$isLayout"/>
                </div>
                @endforeach
            </div>

        @elseif ($row['settings']['columnAsSlides'])

            @php

                $settingsSwiperOptions = $row['settings']['swiperOptions'];
                $rowSwiperOptions = [
                    'grabCursor' => true,
                    'spaceBetween' => 15,
                    'loop' => $settingsSwiperOptions['loop'],
                    'slidesPerView' => 1 + $settingsSwiperOptions['nextPrevVisibleArea']['sm'],
                    'breakpoints' => [
                        400 => [
                            'slidesPerView' => $settingsSwiperOptions['columnCounts']['sm'] + $settingsSwiperOptions['nextPrevVisibleArea']['sm'],
                        ],
                        768 => [
                            'slidesPerView' => $settingsSwiperOptions['columnCounts']['md'] + $settingsSwiperOptions['nextPrevVisibleArea']['md']
                        ],
                        998 => [
                            'slidesPerView' => $settingsSwiperOptions['columnCounts']['lg'] + $settingsSwiperOptions['nextPrevVisibleArea']['lg']
                        ],
                        1200 => [
                            'slidesPerView' => $settingsSwiperOptions['columnCounts']['xl'] + $settingsSwiperOptions['nextPrevVisibleArea']['xl']
                        ]
                    ]
                ];

                if($settingsSwiperOptions['pagination']){

                    $rowSwiperOptions['pagination'] = [
                        'el' => ".swiper-pagination",
                        'clickable' => true,
                        'dynamicBullets' => true
                    ];
                }

                if($settingsSwiperOptions['navigation']){

                    $rowSwiperOptions['navigation'] = [
                        'nextEl' => ".swiper-button-next",
                        'prevEl' => ".swiper-button-prev",
                    ];
                }

                $jsonSwiperOptions = json_encode($rowSwiperOptions);

            @endphp

            <div @class(['position-relative','zindex-2'])>
                <div id="swiper-{{$row['settings']['id']}}" @class(['swiper','ea-swiper','position-relative','opacity-100','overlow-hidden','pb-0']) data-swiper-options="{{$jsonSwiperOptions}}">
                    
                    @if ($settingsSwiperOptions['navigation'] && $settingsSwiperOptions['navigationPosition'] == 'navigation-top-right')
                    <div class="swiper-navigation-div navigation-top-right no-gutter">
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                    @endif

                    <div class="swiper-wrapper align-items-stretch">
                        @foreach ($row['columns'] as $column)
                        <div class="swiper-slide my-0 h-auto overlow-hidden position-relative">
                            <x-column :column="$column" :content="$content" :tabOrSlideDiv="$columnsTabOrSlide" :is-layout="$isLayout"/>
                        </div>
                        @endforeach
                    </div>

                    @if ($settingsSwiperOptions['pagination'])
                    <div class="swiper-pagination"></div>
                    @endif

                    @if ($settingsSwiperOptions['navigation'] && $settingsSwiperOptions['navigationPosition'] == 'navigation-default')
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                    @endif

                    @if ($settingsSwiperOptions['navigation'] && $settingsSwiperOptions['navigationPosition'] == 'navigation-bottom-right')
                    <div class="swiper-navigation-div no-gutter">
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                    @endif

                    @if ($settingsSwiperOptions['navigation'] && $settingsSwiperOptions['navigationPosition'] == 'navigation-bottom-left')
                    <div class="swiper-navigation-div navigation-bottom-left no-gutter">
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                    @endif

                </div>
            </div>

        @else
        
            @foreach ($row['columns'] as $column)
            <x-column :column="$column" :content="$content" :is-layout="$isLayout"/>
            @endforeach
        
        @endif

    @endif

</div>
@endif