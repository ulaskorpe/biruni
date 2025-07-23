@php
    
    $display = true;

    if( $isMobile && !$section['settings']['display']['mobile'] ){
        $display = false;
    }

    if( !$isMobile && !$section['settings']['display']['desktop'] ){
        $display = false;
    }

    $classes = ['d-flex','flex-column','position-relative','content-section'];

    if(isset($section['settings']['fadeInUp']) && $section['settings']['fadeInUp']) {
        $classes[] = 'animate__animated';
        $classes[] = 'anim-opacity-0';
    }

    if($section['settings']['class']) $classes[] = $section['settings']['class'];
    foreach ($section['settings']['margin'] as $key => $value) {
        if($value) $classes[] = $value;
    }
    foreach ($section['settings']['padding'] as $key => $value) {
        if($value) $classes[] = $value;
    }

    $bgExtraClasses = ['overlay'];
    $bgAnimation = false;
    $bgAnimationClass = "";

    if(isset($section['settings']['background']['relativeSize'])) {
        $bgExtraClasses[] = $section['settings']['background']['relativeSize'];
    }

    if(isset($section['settings']['background']['relativePosition'])) {
        $bgExtraClasses[] = $section['settings']['background']['relativePosition'];
    }

    if(isset($section['settings']['background']['animated']) && isset($section['settings']['background']['animation']) && $section['settings']['background']['animated'] === true && !empty($section['settings']['background']['animation'])) {
        $bgExtraClasses[] = 'animate__animated anim-opacity-0';
        $bgAnimation = true;
        $bgAnimationClass = $section['settings']['background']['animation'];
    }
    
    $sectionId = $isLayout ? 'section_'.Str::uuid() : $section['settings']['id'];

@endphp

@if ( $display )

    <section @class($classes) id="{{$sectionId}}"@if (isset($section['settings']['fadeInUp']) && $section['settings']['fadeInUp']) data-animation="{{$bgAnimationClass}}"@endif>

        @if ($section['settings']['background']['color'])
        <div @class([implode(' ',$bgExtraClasses),$section['settings']['background']['color']])@if ($bgAnimation) data-animation="{{$bgAnimationClass}}" @endif></div>
        @endif

        @if ($section['settings']['background']['image'] && !$section['settings']['background']['parallax'])
        <div @class([implode(' ',$bgExtraClasses),$section['settings']['background']['size'],$section['settings']['background']['position']]) data-bg-image="{{$section['settings']['background']['image']}}"@if ($bgAnimation) data-animation="{{$bgAnimationClass}}" @endif></div>
        @endif

        @if ($section['settings']['background']['image'] && $section['settings']['background']['parallax'])
        <div class="parallax" data-parallax-image="{{$section['settings']['background']['image']}}"></div>
        @endif

        @if ($section['settings']['background']['layer']['color'])
        <div @class([implode(' ',$bgExtraClasses),'delay-100ms',$section['settings']['background']['layer']['color'],$section['settings']['background']['layer']['opacity']])@if ($bgAnimation) data-animation="{{$bgAnimationClass}}" @endif></div>
        @endif

        @if (count($section['containers']) > 0)

            @if (isset($section['settings']['containerAsTabs']) && $section['settings']['containerAsTabs'] === true)

            <div class="container position-relative">
                
                @if (!empty($section['settings']['name']) && $section['settings']['name'] != 'Section')
                    <h2 class="text-center mb-4">{{$section['settings']['name']}}</h2>
                @endif

                <div class="d-flex flex-column align-items-center">

                    @if ($isMobile)
                    <ul class="nav nav-tabs pb-1 d-flex flex-row flex-nowrap gap-1 mb-4 position-static overflow-auto w-100" role="tablist">
                        @foreach ($section['containers'] as $container)
                        <li class="nav-item" role="presentation">
                            <button @class(['btn btn-light btn-sm px-2 py-1 text-nowrap fw-semibold', 'active' => $loop->first]) data-bs-toggle="tab" data-bs-target="#{{$container['settings']['id']}}" type="button" role="tab" aria-controls="{{$container['settings']['id']}}" aria-selected="true">{!! $container['settings']['name'] !!}</button>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <ul class="nav nav-tabs pb-1 d-inline-flex gap-1 mb-4 justify-content-center border-0" role="tablist">
                        @foreach ($section['containers'] as $container)
                        <li class="nav-item" role="presentation">
                            <button @class(['btn font-title px-4 lead-responsive border-0 fw-semibold', 'active' => $loop->first]) data-bs-toggle="tab" data-bs-target="#{{$container['settings']['id']}}" type="button" role="tab" aria-controls="{{$container['settings']['id']}}" aria-selected="true">{!! $container['settings']['name'] !!}</button>
                        </li>
                        @endforeach
                    </ul>
                    @endif

                    <div class="tab-content w-100">
                        @foreach ($section['containers'] as $container)
                        <div @class(['tab-pane','show active' => $loop->first]) id="{{$container['settings']['id']}}" role="tabpanel" tabindex="0">
                            <x-container :container="$container" :content="$content"/>
                        </div>
                        @endforeach
                    </div>

                </div>

            </div>

            @elseif (isset($section['settings']['containerAsSlides']) && $section['settings']['containerAsSlides'] === true)

                @php

                    $sectionSwiperOptions = [
                        'grabCursor' => true,
                        'slidesPerView' => 1,
                        'spaceBetween' => 0,
                    ];

                    $jsonSwiperOptions = json_encode($sectionSwiperOptions);

                @endphp

                <div @class(['position-relative','zindex-2'])>
                    <div id="swiper-{{$section['settings']['id']}}" @class(['swiper','ea-swiper','position-relative','opacity-100','overlow-hidden','pb-0']) data-swiper-options="{{$jsonSwiperOptions}}">
                        <div class="swiper-wrapper h-100">
                            @foreach ($section['containers'] as $container)
                            <div class="swiper-slide my-0 overlow-hidden h-100 position-relative">
                                <x-container :container="$container" :content="$content"/>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            @else

            @foreach ($section['containers'] as $container)
            <x-container :container="$container" :content="$content"/>
            @endforeach
            
            @endif

        @endif

    </section>
    
@endif