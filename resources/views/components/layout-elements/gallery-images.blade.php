@if ($galleryImages)

    @php
        $galleryId = Str::uuid();
        $galleryType = $element['data']['type'] ?? 'carousel';
    @endphp

    @if ($galleryType == 'grid')
    
    <div @class(getBaseAndAnimClasses($element['data']))>
        <div class="row g-2 row-cols-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-6">
            @foreach ($galleryImages as $media)
            <a data-fancybox="{{$galleryId}}" href="{{ $media->original_url }}" class="col">
                <img loading="lazy" class="img-fluid" src="{{ $media->preview_url }}" alt="{{ $media->name }}" width="300" height="300">
            </a>
            @endforeach
        </div>
    </div>

    @else

    <div @class(getBaseAndAnimClasses($element['data']))>

        <div class="swiper" id="swiper-{{$galleryId}}">
            <div class="swiper-wrapper">
                @foreach ($galleryImages as $media)
                <a data-fancybox="{{$galleryId}}" href="{{ $media->original_url }}" class="swiper-slide h-250px h-xl-350px w-auto my-0">
                    <img loading="lazy" class="h-100 w-100 object-fit-cover" src="{{ $media->original_url }}" alt="{{ $media->name }}" width="{{ $media->custom_properties['width'] }}" height="{{ $media->custom_properties['height'] }}">
                    <div class="swiper-lazy-preloader"></div>
                </a>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
        
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const swiper = new Swiper('#swiper-{{$galleryId}}',{
                slidesPerView: 'auto',
                freeMode:false,
                spaceBetween: 15,
                mousewheel: true,
                grabCursor:true,
                keyboard: {
                    enabled: true,
                },
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: true,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                    dynamicBullets: true
                }
            });
        });
    </script>

    @endif

@endif