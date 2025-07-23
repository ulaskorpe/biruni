@props([
    'element' => null
])

@if ($element)

@php

    $elemData = $element['data'];
    $elemDivClasses = [];

    if($elemData['baseDesignOptions']['class']) $elemDivClasses[] = $elemData['baseDesignOptions']['class'];
    if(isset($elemData['baseDesignOptions']['position'])) $elemDivClasses[] = $elemData['baseDesignOptions']['position'];

    foreach ($elemData['baseDesignOptions']['margin'] as $key => $value) {
        if($value) $elemDivClasses[] = $value;
    }
    foreach ($elemData['baseDesignOptions']['padding'] as $key => $value) {
        if($value) $elemDivClasses[] = $value;
    }

    $timelineUuid = Str::uuid();

@endphp

<div @class($elemDivClasses)>

    <div class="row g-4 g-xl-5 align-items-center">

        <div class="col-lg-6">

            <div class="swiper timeline-swiper" data-swiper-uuid="{{$timelineUuid}}">

                @if (isset($elemData['sliderTitle']) && !empty($elemData['sliderTitle']) && $isMobile)
                    <h2 class="mb-4 fw-bolder text-center">{!! $elemData['sliderTitle'] !!}</h2>
                @endif

                <div class="swiper-wrapper">
                    @foreach ($elemData['accItems'] as $item)
                
                    <div class="swiper-slide">
                        <img src="{{$item['accMedia']['original_url']}}" alt="" class="img-fluid" />
                        <div class="vstack gap-2 mt-3 d-lg-none text-center">
                            <p class="mb-0 lead-responsive fw-bold">{{$item['accTitle']}}</p>
                            <p class="mb-0">{{$item['accDescription']}}</p>
                        </div>
                    </div>
    
                    @endforeach
                </div>

            </div>

        </div>

        <div class="col-lg-6 d-none d-lg-flex flex-column">

            @if (isset($elemData['sliderTitle']) && !empty($elemData['sliderTitle']) && !$isMobile)
                <h2 class="mb-4 fw-bolder">{!! $elemData['sliderTitle'] !!}</h2>
            @endif

            <div class="timeline vstack gap-0"  id="timeline-{{$timelineUuid}}">

                @foreach ($elemData['accItems'] as $item)
                
                <div @class(['timeline-item vstack cursor-pointer','active' => $loop->first])>
                    <p class="mb-0 lead-responsive fw-bold timeline-title">{{$item['accTitle']}}</p>
                    <p class="mb-0">{{$item['accDescription']}}</p>
                </div>

                @endforeach

            </div>

        </div>

    </div>

</div>


@endif