@props([
    'element' => null
])

@if ($element && !empty($element['data']['content']))

    @php

        $modalDialogClasses = ['modal-dialog modal-dialog-centered'];
        $modalContentClasses = ['modal-content'];

        if(!empty($element['data']['size'])){
            $modalDialogClasses[] = $element['data']['size'];
        }

        if(!empty($element['data']['extraClasses'])){
            $modalContentClasses[] = $element['data']['extraClasses'];
        }

    @endphp

    <div class="modal fade" id="{{$element['data']['modalId']}}" aria-labelledby="{{$element['data']['modalId']}}Label" tabindex="-1" aria-hidden="true">
        <div @class($modalDialogClasses)>
            <div @class($modalContentClasses)>
                <div class="modal-header">
                    <div class="modal-title lead-responsive" id="{{$element['data']['modalId']}}Label">{{$element['data']['title']}}</div>
                    <button type="button" class="btn box-30 p-0 d-flex align-items-center justify-content-center rounded-circle bg-white text-primary ms-auto" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-body">
                    @if (isset($element['data']['content'][0]['containers'][0]))
                    @foreach ($element['data']['content'][0]['containers'][0]['rows'] as $row)
                        <x-row :row="$row" :is-layout="true"/>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if ($element['data']['opneOnPageLoad'] === true)
    <script>
        window.addEventListener('DOMContentLoaded', function(){
            openModal("{{$element['data']['modalId']}}");
        });
    </script>
    @endif

@endif