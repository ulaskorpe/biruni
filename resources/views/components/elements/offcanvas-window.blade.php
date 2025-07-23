@props([
    'element' => null
])

@if ($element && !empty($element['data']['content']))

    @php

        $canvasClasses = ['offcanvas'];

        if(!empty($element['data']['size']) && in_array($element['data']['position'],['offcanvas-start','offcanvas-end'])){
            $canvasClasses[] = $element['data']['size'];
        }

        if(!empty($element['data']['position'])){
            $canvasClasses[] = $element['data']['position'];
        }

        if(!empty($element['data']['extraClasses'])){
            $canvasClasses[] = $element['data']['extraClasses'];
        }

        $containerClass = ['container'];
        if($element['data']['contentAreaFull'] && in_array($element['data']['position'],['offcanvas-top','offcanvas-bottom'])){
            $containerClass = ['container-fluid'];
        }

    @endphp

    <div @class($canvasClasses) id="offcanvas-{{$element['data']['modalId']}}" tabindex="-1">
        <div class="offcanvas-body px-0">

            <div @class($containerClass)>
                
                <div class="d-flex align-items-center gap-2 mb-4">
                    <div class="lead-responsive">{!! $element['data']['title'] !!}</div>
                    <button type="button" class="btn box-30 p-0 d-flex align-items-center justify-content-center rounded-circle bg-light text-primary ms-auto" data-bs-dismiss="offcanvas" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                @if (isset($element['data']['content'][0]['containers'][0]))
                @foreach ($element['data']['content'][0]['containers'][0]['rows'] as $row)
                    <x-row :row="$row" :is-layout="true"/>
                @endforeach
                @endif

            </div>
        </div>
        
    </div>

    @if ($element['data']['opneOnPageLoad'] === true)
    <script>
        window.addEventListener('DOMContentLoaded', function(){
            openOffcanvas("offcanvas-{{$element['data']['modalId']}}");
        });
    </script>
    @endif

@endif