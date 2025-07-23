@php
    $elemData = $element['data'];

    $elemClasses = [];

    if($elemData['type'] == 'grid'){
        $elemClasses[] = 'row';
        $elemClasses[] = 'g-3';
        $elemClasses[] = 'row-cols-'.$elemData['columnCounts']['sm'];
        $elemClasses[] = 'row-cols-md-'.$elemData['columnCounts']['md'];
        $elemClasses[] = 'row-cols-lg-'.$elemData['columnCounts']['lg'];
        $elemClasses[] = 'row-cols-xl-'.$elemData['columnCounts']['xl'];
    }

    if($elemData['type'] == 'carousel'){
        $elemClasses[] = 'ea-swiper';
        $elemClasses[] = 'swiper';
    }

    $customLayout = null;
    if(isset($elemData['cardType']) && $elemData['cardType'] == 'custom'){
        $cardLayout = \App\Models\CardLayout::find($elemData['customCardLayout']);
        if( $cardLayout ){
            $customLayout = $cardLayout;
        }
    }

@endphp

<div @class(getBaseAndAnimClasses($elemData))>
    
    @switch($elemData['type'])

        @case('carousel')
        
        <div @class($elemClasses) data-swiper-options="{{$elemData['swiperOptions']}}">
            <div @class(['swiper-wrapper'])>
                @foreach ($dependingContents as $key => $content)
                <div @class(['swiper-slide','d-flex','h-auto','align-items-center'])>

                    @if ($customLayout)
                    <x-cards.dynamic-card :content="$content" :card-layout="$customLayout"/>
                    @else
                    <x-cards.content-card :content="$content"/>
                    @endif

                </div>
                @endforeach
            </div>
            @if ($elemData['pagination'])
            <div class="swiper-pagination"></div>
            @endif
            @if ($elemData['navigation'])
            <div class="swiper-theme-prev"></div>
            <div class="swiper-theme-next"></div>
            @endif
        </div>

        @break

        @case('accordeon')
        
        <div @class($elemClasses)>
            @php
                $accId = 'acc-'.Str::uuid();
            @endphp
            <div class="accordion vstack gap-3" id="{{$accId }}">
            @foreach ($dependingContents as $key => $content)
            <div class="accordion-item bg-white rounded border-0">
                <h4 class="accordion-header">
                  <button class="accordion-button rounded fw-semibold bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acc-collapse-{{$content->id}}" aria-expanded="true" aria-controls="acc-collapse-{{$content->id}}">
                    {!! $content->name !!}
                  </button>
                </h4>
                <div id="acc-collapse-{{$content->id}}" class="accordion-collapse collapse" data-bs-parent="#{{$accId }}">
                  <div class="accordion-body pt-0">
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

                if($elemData['animOptions'] && $elemData['animOptions']['use']) {
                    $collClasses[] = 'animate__animated anim-opacity-0';
                    $colAnimation = true;
                    $colAnimationClass = $elemData['animOptions']['class'];
                }

            @endphp

            @foreach ($dependingContents as $key => $content)

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