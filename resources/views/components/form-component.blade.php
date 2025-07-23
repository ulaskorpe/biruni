@php
    $formId = 'form'.Str::uuid();    
@endphp

@if ($form->is_modal)
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{$formId}}">{{ $form->modal_button_text }}</button>
<div class="modal fade" id="{{$formId}}" tabindex="-1" aria-labelledby="{{$formId}}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <span class="modal-title fs-5" id="{{$formId}}Label">{{ __('Bize Ulaşın') }}</span>
                <button type="button" class="btn btn-bg-primary text-white px-2 py-0" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x fs-4"></i></button>
            </div>
            <div class="modal-body bg-light">
                <x-form-component-html :form="$form" />
            </div>
        </div>
    </div>
</div>
@else
<x-form-component-html :form="$form" :form-id="$formId"/>
@endif