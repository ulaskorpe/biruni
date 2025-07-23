<x-fe-layout :content="$content" :is-home="true">

    @if ($content->slider)

        @php

            $swiperOptions = [
                'loop' => true,
                //'centeredSlides' => true,
                'lazyPreloadPrevNext' => 0,
                // 'pagination' => [
                //     'el' => '.swiper-pagination',
                //     'clickable' => true,
                //     'dynamicBullets' => true
                // ],
                'autoplay' => [
                    'delay' => 7000,
                    'disableOnInteraction' => true
                ],
                'grabCursor' => true,
                'slidesPerView' => 1,
                'spaceBetween' => 0,
                'navigation' => [
                    'nextEl' => '.swiper-button-next',
                    'prevEl' => '.swiper-button-prev'
                ]
            ];

            $jsonOptions = json_encode($swiperOptions);

        @endphp

        <div @class(['position-relative']) id="home-slider">

            <div @class(['swiper','ea-swiper','position-relative','opacity-100','overlow-hidden','p-0','h-100', 'container','zindex-2']) data-swiper-options="{{$jsonOptions}}">
                <div class="swiper-wrapper overlow-hidden h-100 zindex-2">
                    @foreach ($content->slider->slides as $slide)
                    <div class="swiper-slide my-0 overlow-hidden w-100 h-100 position-relative">

                        <div class="content-section text-center">
                            <div class="container w-xl-75">

                                @if ($slide->title)
                                <div class="text-white h2 bigtitle-responsive">{!! $slide->title !!}</div>
                                @endif
                                @if ($slide->description)
                                <p class="text-white mb-0">
                                    {!! $slide->description !!}
                                </p>
                                @endif
                                @if ($slide->json_data['buttons']['button_1']['active'] || $slide->json_data['buttons']['button_2']['active'])
                                <div class="d-flex justify-content-center align-items-center gap-2 mt-4">
                                    @if ($slide->json_data['buttons']['button_1']['active'])
                                    <a href="{{$slide->json_data['buttons']['button_1']['link']}}" class="btn btn-primary d-inline-flex align-items-center gap-3">
                                        {{$slide->json_data['buttons']['button_1']['text']}}
                                        <img class="img-fluid" src="/media/2025/3/3/arrow-whitesvg.svg" width="31" height="30">
                                    </a>
                                    @endif
                                    @if ($slide->json_data['buttons']['button_2']['active'])
                                    <a href="{{$slide->json_data['buttons']['button_2']['link']}}" class="btn btn-secondary">
                                        {{$slide->json_data['buttons']['button_2']['text']}}
                                    </a>
                                    @endif
                                </div>
                                @endif

                                <div class="mt-5">
                                @if ($isMobile && $slide->mobile_image)
                                    <img @if(!$loop->first)loading="lazy"@endif src="{{ $slide->mobile_image['original_url'] }}" alt="{{ $slide->title }}" width="{{$slide->mobile_image['custom_properties']['width']}}" height="{{$slide->mobile_image['custom_properties']['height']}}" @class(['img-fluid mx-auto'])>
                                    @elseif ($slide->image)
                                    <img @if(!$loop->first)loading="lazy"@endif src="{{ $slide->image['original_url'] }}" alt="{{ $slide->title }}" width="{{$slide->image['custom_properties']['width']}}" height="{{$slide->image['custom_properties']['height']}}" @class(['img-fluid mx-auto'])>
                                    @endif
                                </div>

                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>
                @if (!$isMobile)
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                @endif
            </div>

        </div>

    @endif

    @if (count($content->content) > 0)
        @foreach ($content->content as $section)
        <x-section :section="$section" :content="$content"/>
        @endforeach
    @endif

    <x-slot name="headerScripts">

        {!! $content->additional['headerScripts'] !!}
        
    </x-slot>

    <x-slot name="footerScripts">

        {!! $content->additional['footerScripts'] !!}

    </x-slot>

</x-fe-layout>