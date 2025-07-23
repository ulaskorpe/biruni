@php
    $swiperId = null;
    if(isset($data['swiperId']) && !empty($data['swiperId'])){
        $swiperId = $data['swiperId'];
    }
@endphp

@if ($swiperId)
    <div class="d-flex w-auto position-relative align-items-center gap-2 h-40px">
        <div onclick="document.getElementById('{{$swiperId}}').swiper.slidePrev();" class="swiper-button-prev position-relative end-0 start-0" tabindex="0" role="button" aria-label="Previous slide"></div>
        <div onclick="document.getElementById('{{$swiperId}}').swiper.slideNext();" class="swiper-button-next position-relative end-0 start-0" tabindex="0" role="button" aria-label="Next slide"></div>
    </div>
@endif