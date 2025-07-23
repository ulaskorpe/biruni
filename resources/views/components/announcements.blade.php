@props([
    'navbar' => false
])

@php
    
    $announcements = \App\Models\Announcement::when( !Auth::check(), function($query){
        $query->where('users_only',false);
    })->orderBy('id','desc')->take(5)->get();

@endphp

@if ($announcements->count() > 0)
<div @class([
    'bg-secondary d-flex w-100 align-items-center',
    'navbar-announcements h-50px' => $navbar
])>

    <div class="container zindex-1">
        <div class="position-relative overflow-hidden">
            <div class="ea-swiper swiper" data-swiper-options='{"slidesPerView":1,"autoplay":{"delay": 5000}}'>
                <div class="swiper-wrapper w-100 h-100 align-items-center pb-0">
                    @foreach ($announcements as $ann)
                    <div class="swiper-slide d-flex w-100 fw-semibold text-center justify-content-center">
                        @if ($navbar)
                            <small>{{ $ann->description }}</small>
                        @else
                            {{ $ann->description }}
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <span class="cursor-pointer position-absolute end-0 top-0 mt-1 me-2 zindex-2" onclick="this.closest('.navbar-announcements').remove();"><i class="bi bi-x-lg fs-4"></i></span>

</div>
@endif