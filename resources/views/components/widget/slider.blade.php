@php
    
    $selectedSlider = null;
    if( $slider['slider'] ){
        $selectedSlider = \App\Models\Slider::where('id',$slider['slider']['id'])->with('slides')->first();
    }

    $elemDivClasses = [];

    if( $selectedSlider ){

        $elemDivClasses = ['ea-swiper','swiper','d-flex', $slider['height']];

        if( isset($slider['slideType']) ){

            if($slider['slideType'] == 'type-1') $elemDivClasses[] = 'type-one';
            if($slider['slideType'] == 'type-2') $elemDivClasses[] = 'type-two';
            if($slider['slideType'] == 'type-3') $elemDivClasses[] = 'type-three';

        }

        if($slider['baseDesignOptions']['class']) $elemDivClasses[] = $slider['baseDesignOptions']['class'];
        if(isset($slider['baseDesignOptions']['position'])) $elemDivClasses[] = $slider['baseDesignOptions']['position'];

        foreach ($slider['baseDesignOptions']['margin'] as $key => $value) {
            if($value) $elemDivClasses[] = $value;
        }
        foreach ($slider['baseDesignOptions']['padding'] as $key => $value) {
            if($value) $elemDivClasses[] = $value;
        }

    }

@endphp

@if ($selectedSlider && $slider['slideType'])


@switch($slider['slideType'])
    
    @case('type-1')
    <div @class(['position-relative overflow-hidden w-100'])>
        <div @class($elemDivClasses) data-swiper-options="{{$slider['swiperOptions']}}">
            <div @class(['swiper-wrapper'])>
                
                @foreach ($selectedSlider['slides'] as $slide)
    
                <div @class(['swiper-slide'])>
    
                    <div class="position-relative rounded-3 overflow-hidden h-100 w-100">
                        @if ($slide['video'])
                            
                            <video class="bg-video" autoplay muted loop poster="{{ $slide['image'] ? $slide['image']['original_url'] : '' }}">
                                <source src="{{$slide['video']['original_url']}}" type="video/mp4">
                            </video>

                        @else
                            
                            @if ($isMobile && $slide->mobile_image)
                            <div class="overlay bg-cover bg-center-top zindex-1" data-bg-image="{{$slide->mobile_image['original_url']}}"></div>
                            @elseif ($isMobile && $slide->image)
                            <div class="overlay bg-cover bg-center-top zindex-1" data-bg-image="{{$slide->image['conversion_urls']['992x500_url']}}"></div>
                            @elseif ($slide->image)
                            <div class="overlay bg-cover bg-center-top zindex-1" data-bg-image="{{$slide->image['original_url']}}"></div>
                            @endif


                        @endif
        
                        <div class="slide-content-area position-relative zindex-3 p-4 p-xxl-5 text-center text-white d-flex flex-column h-100 bg-v-gradient-reverse-secondary justify-content-end">
                            <div class="subtitle-responsive font-title text-white">{!! $slide['title'] !!}</div>
                            @if (!empty($slide['description']))
                            <p class="mb-0 mt-3 w-xl-75 w-xxl-50 mx-auto">{!! $slide['description'] !!}</p>
                            @endif
                            @if ($slide['json_data']['buttons']['button_1']['active'])
                            <div class="mt-4 hstack gap-2 justify-content-center">
                                <a href="{{$slide['json_data']['buttons']['button_1']['link']}}" class="btn btn-primary">{{$slide['json_data']['buttons']['button_1']['text']}}</a>
                                @if ($slide['json_data']['buttons']['button_2']['active'])
                                <a href="{{$slide['json_data']['buttons']['button_2']['link']}}" class="btn btn-light">{{$slide['json_data']['buttons']['button_2']['text']}}</a>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
    
                </div>
    
                @endforeach

                @if (count($selectedSlider['slides']) < 4)
                @foreach ($selectedSlider['slides'] as $slide)
    
                <div @class(['swiper-slide'])>
    
                    <div class="position-relative rounded-3 overflow-hidden h-100 w-100">
                        @if ($slide['video'])
                            
                            <video class="bg-video" autoplay muted loop poster="{{ $slide['image'] ? $slide['image']['original_url'] : '' }}">
                                <source src="{{$slide['video']['original_url']}}" type="video/mp4">
                            </video>

                        @else
                            
                            @if ($isMobile && $slide->mobile_image)
                            <div class="overlay bg-cover bg-center-top zindex-1" data-bg-image="{{$slide->mobile_image['original_url']}}"></div>
                            @elseif ($isMobile && $slide->image)
                            <div class="overlay bg-cover bg-center-top zindex-1" data-bg-image="{{$slide->image['conversion_urls']['992x500_url']}}"></div>
                            @elseif ($slide->image)
                            <div class="overlay bg-cover bg-center-top zindex-1" data-bg-image="{{$slide->image['original_url']}}"></div>
                            @endif


                        @endif
        
                        <div class="slide-content-area position-relative zindex-3 p-4 p-xxl-5 text-center text-white d-flex flex-column h-100 bg-v-gradient-reverse-secondary justify-content-end">
                            <div class="subtitle-responsive font-title text-white">{!! $slide['title'] !!}</div>
                            @if (!empty($slide['description']))
                            <p class="mb-0 mt-3 w-xl-75 w-xxl-50 mx-auto">{!! $slide['description'] !!}</p>
                            @endif
                            @if ($slide['json_data']['buttons']['button_1']['active'])
                            <div class="mt-4 hstack gap-2 justify-content-center">
                                <a href="{{$slide['json_data']['buttons']['button_1']['link']}}" class="btn btn-primary">{{$slide['json_data']['buttons']['button_1']['text']}}</a>
                                @if ($slide['json_data']['buttons']['button_2']['active'])
                                <a href="{{$slide['json_data']['buttons']['button_2']['link']}}" class="btn btn-light">{{$slide['json_data']['buttons']['button_2']['text']}}</a>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
    
                </div>
    
                @endforeach
                @endif

            </div>
            @if ($slider['pagination'])
            <div class="swiper-pagination"></div>
            @endif
            @if ($slider['navigation'])
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            @endif
        </div>
    </div>
    @break

    @default

    <div @class(['position-relative overflow-hidden',$slider['height']])>
        <div @class($elemDivClasses) data-swiper-options="{{$slider['swiperOptions']}}">
            <div @class(['swiper-wrapper',$slider['height']])>
                @foreach ($selectedSlider['slides'] as $slide)
    
                <div @class(['swiper-slide','d-flex','flex-column','h-100','justify-content-end','pb-8',$slider['height']])>
    
                    @if ($slide['video'])
                        <video class="bg-video" autoplay muted loop poster="{{ $slide['image'] ? $slide['image']['original_url'] : '' }}">
                            <source src="{{$slide['video']['original_url']}}" type="video/mp4">
                        </video>
                    @else
                        <div class="overlay bg-cover bg-center-top zindex-1" @if ($slide['image']) data-bg-image="{{$slide['image']['original_url']}}" @endif></div>
                        <div class="overlay zindex-2 bg-primary opacity-30"></div>
                    @endif
    
                    <div class="container position-relative px-3 zindex-3">
    
                        <div class="row">
                            <div @class(['col-lg-10 col-xl-8'])>
                                <div class="text-white">
                                    <div class="title-responsive fw-bold mb-1 lh-1">{!! $slide['title'] !!}</div>
                                    <p @class(['p-responsive mb-0 lh-1'])>{{ $slide['description'] }}</p>
                                    @if ($slide['json_data']['buttons']['button_1']['active'])
                                    <div class="mt-4 hstack gap-3">
                                        <a href="{{$slide['json_data']['buttons']['button_1']['link']}}" class="btn btn-primary">{{$slide['json_data']['buttons']['button_1']['text']}}</a>
                                        @if ($slide['json_data']['buttons']['button_2']['active'])
                                        <a href="{{$slide['json_data']['buttons']['button_2']['link']}}" class="btn btn-light">{{$slide['json_data']['buttons']['button_2']['text']}}</a>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
    
                    </div>
    
                </div>
    
                @endforeach
            </div>
            @if ($slider['pagination'])
            <div class="swiper-pagination"></div>
            @endif
            @if ($slider['navigation'])
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            @endif
        </div>
    </div>
        
@endswitch

@endif